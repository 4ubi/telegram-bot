<?php

namespace App\Bot\Telegram\ScenarioCommand;

use App\Bot\Telegram\Enum\BotScenarioCommandsEnum;
use App\Bot\Telegram\Model\Message;

class UserFinishedScenarioCommand implements ScenarioCommandInterface
{

    public function support(Message $message): bool
    {
        return  BotScenarioCommandsEnum::USER_WANT_FINISHED->value === $message->bodyMessage->textBody;
    }

    public function process(Message $message): ScenarioResult
    {
        $startScenario = new StartScenarioCommand();

        return $startScenario->process($message);
    }
}