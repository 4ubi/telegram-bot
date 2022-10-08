<?php

namespace App\Controller;

use App\Bot\Telegram\TelegramBot;
use BotMan\BotMan\BotMan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/webhook')]
class TelegramWebhookController extends AbstractController
{
    public function __construct(readonly TelegramBot $telegramBot)
    {
    }

    #[Route(path: '/telegram', methods: ['GET', 'POST'])]
    public function telegram(): Response
    {
        $botMan = $this->telegramBot->getBotMan();

        $botMan->hears('start', function (BotMan $bot) {
            $bot->reply('Ты попуск');
        });

        $botMan->listen();

        return new Response('Ты бурятская морда =)', headers: ['ngrok-skip-browser-warning' => false]);
    }
}