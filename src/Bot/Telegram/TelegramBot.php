<?php

namespace App\Bot\Telegram;

use App\Bot\Telegram\Enum\BotScenarioCommandsEnum;
use App\Bot\Telegram\Model\Message;
use App\Bot\Telegram\ScenarioCommand\ScenarioCommandInterface;
use App\Bot\Telegram\ScenarioCommand\ScenarioResult;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\Request;

class TelegramBot
{
    public const SEND_VIDEO_METHOD = 'sendVideo';
    public const SEND_MESSAGE_METHOD = 'sendMessage';
    public const SEND_VIDEO_NOTE_METHOD = 'sendVideoNote';

    /**
     * @param ClientInterface $client
     * @param ScenarioCommandInterface[] $scenaries
     */
    public function __construct(private ClientInterface $client, private iterable $scenaries)
    {
    }

    public function handleMessage(Message $message): void
    {
        foreach ($this->scenaries as $scenario) {
            if (!$scenario->support($message)) {
                continue;
            }

            $resultScenario = $scenario->process($message);

            $this->sendResultAction($resultScenario);
        }
    }

    private function sendResultAction(ScenarioResult $result): void
    {
        $this->client->request(
            $result->method,
            $result->actionApiMethod,
            [
                RequestOptions::HEADERS => [
                    "Content-Type" => "application/json",
                ],
                RequestOptions::BODY    => json_encode($result->result),
            ]
        );
    }
}