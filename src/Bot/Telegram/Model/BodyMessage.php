<?php

namespace App\Bot\Telegram\Model;

class BodyMessage
{
    public function __construct(
        readonly bool $isFile = false,
        readonly ?string $textBody = null,
        readonly ?File $fileBody = null,
    ) {
    }
}