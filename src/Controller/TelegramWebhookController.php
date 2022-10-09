<?php

namespace App\Controller;

use App\Bot\Telegram\Factory\MessageFactory;
use App\Bot\Telegram\TelegramBot;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

;

#[Route(path: '/webhook')]
class TelegramWebhookController extends AbstractController
{
    public function __construct(
        private TelegramBot $telegramBot,
        private MessageFactory $messageFactory,
        readonly LoggerInterface $logger
    ) {
    }

    #[Route(path: '/telegram', methods: ['GET', 'POST'])]
    public function telegram(Request $request): Response
    {
        try {
            $requestContent = json_decode($request->getContent(), true);
            $message        = $this->messageFactory->createMessageFromResponse($requestContent);

            $this->telegramBot->handleMessage($message);
        } catch (Throwable $exception) {
            $this->logger->error(
                'Telegram webhook ERROR {message}',
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception,
                    'request' => $request,
                ]
            );

            return new Response(status: Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response('ok');
    }
}