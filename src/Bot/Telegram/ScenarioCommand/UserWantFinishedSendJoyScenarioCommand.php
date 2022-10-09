<?php

namespace App\Bot\Telegram\ScenarioCommand;

use App\Bot\Telegram\Enum\BotScenarioCommandsEnum;
use App\Bot\Telegram\Model\Message;

class UserWantFinishedSendJoyScenarioCommand implements ScenarioCommandInterface
{

    public function support(Message $message): bool
    {
        return BotScenarioCommandsEnum::USER_WANT_FINISHED_SEND_JOY->value === $message->bodyMessage->textBody;
    }

    public function process(Message $message): ScenarioResult
    {
        $userReadyScenario = new UserReadyScenarioCommand();

        return $userReadyScenario->process($message);
    }
}