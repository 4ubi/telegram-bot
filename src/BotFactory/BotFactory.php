<?php

namespace App\BotFactory;

use App\Enum\SystemsEnum;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Telegram\TelegramDriver;
use LogicException;

class BotFactory
{
    public function create(array $config, SystemsEnum $system): BotMan
    {
        $this->loadDriver($system);

        return BotManFactory::create($config);
    }

    private function loadDriver(SystemsEnum $system): void
    {
        match ($system) {
            SystemsEnum::TELEGRAM => DriverManager::loadDriver(TelegramDriver::class),
            default => throw new LogicException('Unknown system'),
        };
    }
}