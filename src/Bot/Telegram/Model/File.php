<?php

namespace App\Bot\Telegram\Model;

class File
{
    public function __construct(
        readonly string $type,
        readonly string $fileId,
        readonly string $username,
        readonly string $fileUniqueId,
    ) {
    }
}