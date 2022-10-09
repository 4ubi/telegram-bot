<?php

namespace App\Bot\Telegram\Factory;

use App\Bot\Telegram\Enum\BotScenarioCommandsEnum;
use App\Bot\Telegram\Model\BodyMessage;

class BodyMessageFactory
{
    public function __construct(private FileFactory $fileFactory)
    {
    }

    public function createBodyMessageFromResponse(array $data): BodyMessage
    {
        $isFile = empty($data['text']);
        $file   = null;

        if ($isFile) {
            $file = $this->fileFactory->createFileFromResponse($data);
        }

        $text = !$isFile ? $data['text'] : BotScenarioCommandsEnum::USER_SEND_FILE->value;

        return new BodyMessage(
            $isFile,
            $text,
            $file
        );
    }
}