<?php

namespace App\Bot\Telegram\ScenarioCommand;

use App\Bot\Telegram\Enum\BotScenarioCommandsEnum;
use App\Bot\Telegram\Model\Message;
use App\Bot\Telegram\TelegramBot;
use Symfony\Component\HttpFoundation\Request;

class UserReadyScenarioCommand implements ScenarioCommandInterface
{

    public function support(Message $message): bool
    {
        return BotScenarioCommandsEnum::USER_READY->value === $message->bodyMessage->textBody;
    }

    public function process(Message $message): ScenarioResult
    {
        $data = [
            'chat_id'      => $message->chat->id,
            'text'         => "{$message->user->firstName},прямо сейчас ты можешь “порадоваться”, получив доброе послание от коллеги или “порадовать”, записав свое. Что выбираешь?",
            'reply_markup' => [
                'resize_keyboard' => true,
                'keyboard'        => [
                    [
                        ['text' => BotScenarioCommandsEnum::USER_WANT_SEND_JOY->value],
                        ['text' => BotScenarioCommandsEnum::USER_WANT_GET_JOY->value],
                    ],
                ],
            ],
        ];

        return new ScenarioResult(
            TelegramBot::SEND_MESSAGE_METHOD,
            Request::METHOD_POST,
            $data
        );
    }
}