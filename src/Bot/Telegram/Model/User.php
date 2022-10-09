<?php

namespace App\Bot\Telegram\Model;

class User
{
    public function __construct(
        readonly string $username,
        readonly string $firstName,
        readonly string $lastName,
        readonly string $languageCode,
        readonly bool $isBot = false,
    )
    {
    }
}