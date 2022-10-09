<?php

namespace App\Bot\Telegram\Model;

class Message
{
    public function __construct(
        readonly int $id,
        readonly BodyMessage $bodyMessage,
        readonly int $date,
        readonly Chat $chat,
        readonly User $user
    ) {
    }
}