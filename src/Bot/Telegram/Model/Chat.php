<?php

namespace App\Bot\Telegram\Model;

class Chat
{
    public function __construct(
        readonly int $id,
        readonly string $type
    ) {
    }
}