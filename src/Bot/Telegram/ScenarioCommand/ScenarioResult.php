<?php

namespace App\Bot\Telegram\ScenarioCommand;

class ScenarioResult
{
    public function __construct(
        readonly string $actionApiMethod,
        readonly string $method,
        readonly array $result
    ) {
    }
}