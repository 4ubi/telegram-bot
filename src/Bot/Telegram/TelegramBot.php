<?php

namespace App\Bot\Telegram;

use App\BotFactory\BotFactory;
use App\Enum\SystemsEnum;
use BotMan\BotMan\BotMan;

class TelegramBot
{
    readonly ?BotMan $telegramBotMan;

    public function __construct(readonly array $config)
    {
        $this->telegramBotMan = null;
    }

    public function getBotMan(): ?BotMan
    {
        return $this->init();
    }


    private function init(): BotMan
    {
        if ($this->telegramBotMan) {
            return $this->telegramBotMan;
        }


        $botFactory = new BotFactory();

        return $botFactory->create($this->config, SystemsEnum::TELEGRAM);
    }
}