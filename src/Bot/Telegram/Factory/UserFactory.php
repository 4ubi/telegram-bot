<?php

namespace App\Bot\Telegram\Factory;

use App\Bot\Telegram\Model\User;

class UserFactory
{
    public static function createUserFromResponse(array $data): User
    {
        return new User(
            $data['username'],
            $data['first_name'],
            $data['last_name'],
            $data['language_code'],
            (bool)$data['is_bot']
        );
    }
}