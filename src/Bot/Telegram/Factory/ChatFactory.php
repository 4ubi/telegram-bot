<?php

namespace App\Bot\Telegram\Factory;

use App\Bot\Telegram\Model\Chat;

class ChatFactory
{
    public static function createChatFromResponse(array $data): Chat
    {
        return new Chat(
            $data['id'],
            $data['type']
        );
    }
}