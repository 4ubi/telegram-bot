<?php

namespace App\Bot\Telegram\ScenarioCommand;

use App\Bot\Telegram\Enum\BotScenarioCommandsEnum;
use App\Bot\Telegram\Model\Message;
use App\Bot\Telegram\TelegramBot;
use Symfony\Component\HttpFoundation\Request;

class StartScenarioCommand implements ScenarioCommandInterface
{
    public function support(Message $message): bool
    {
        return BotScenarioCommandsEnum::START->value === $message->bodyMessage->textBody;
    }

    public function process(Message $message): ScenarioResult
    {
        $messageData = [
            'chat_id'      => $message->chat->id,
            'text'         => sprintf(
                "Привет, %s! Рад, что ты присоединился! Давай отвлечемся от тревожных новостей? Я знаю, как поднять тебе настроение:) Готов?",
                $message->user->firstName
            ),
            'reply_markup' => [
                'resize_keyboard' => true,
                'keyboard'        => [
                    [
                        ['text' => BotScenarioCommandsEnum::USER_READY->value],
                    ],
                ],
            ],
        ];

        return new ScenarioResult(
            TelegramBot::SEND_MESSAGE_METHOD,
            Request::METHOD_POST,
            $messageData
        );
    }
}