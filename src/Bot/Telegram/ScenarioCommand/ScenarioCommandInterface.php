<?php

namespace App\Bot\Telegram\ScenarioCommand;

use App\Bot\Telegram\Model\Message;

interface ScenarioCommandInterface
{
    public function support(Message $message): bool;

    public function process(Message $message): ScenarioResult;
}