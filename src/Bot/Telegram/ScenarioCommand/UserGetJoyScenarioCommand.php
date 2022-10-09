<?php

namespace App\Bot\Telegram\ScenarioCommand;

use App\Bot\Telegram\Enum\BotScenarioCommandsEnum;
use App\Bot\Telegram\Model\Message;
use App\Bot\Telegram\TelegramBot;
use App\Entity\TelegramFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserGetJoyScenarioCommand implements ScenarioCommandInterface
{
    private const TEXT_IF_FILE_IS_NULL = 'Пользователи еще не добавили новостей. Ты можешь быть первым, нажми хочу порадовать';

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function support(Message $message): bool
    {
        return BotScenarioCommandsEnum::USER_WANT_GET_JOY->value === $message->bodyMessage->textBody || BotScenarioCommandsEnum::USER_GET_JOY_RETURN->value === $message->bodyMessage->textBody;
    }

    public function process(Message $message): ScenarioResult
    {
        $file = $this->getRandomFileAnotherUsers($message->user->username);

        if (null === $file) {
            $data = [
                'chat_id'      => $message->chat->id,
                'text'         => self::TEXT_IF_FILE_IS_NULL,
                'reply_markup' => [
                    'resize_keyboard' => true,
                    'keyboard'        => [
                        [
                            ['text' => BotScenarioCommandsEnum::USER_WANT_SEND_JOY->value],
                            ['text' => BotScenarioCommandsEnum::USER_WANT_FINISHED->value],
                        ],
                    ],
                ],
            ];

            return $this->createScenarioResult(TelegramBot::SEND_MESSAGE_METHOD, $data);
        }

        $data = [
            'chat_id' => $message->chat->id,
            $file->getType() => $file->getFileId(),
            'reply_markup' => [
                'resize_keyboard' => true,
                'keyboard'        => [
                    [
                        ['text' => BotScenarioCommandsEnum::USER_GET_JOY_RETURN->value],
                        ['text' => BotScenarioCommandsEnum::USER_WANT_FINISHED->value],
                    ],
                ],
            ],
        ];

        $actionApiMethod = $file->getType() === TelegramFile::TYPE_VIDEO ? TelegramBot::SEND_VIDEO_METHOD : TelegramBot::SEND_VIDEO_NOTE_METHOD;

        return $this->createScenarioResult($actionApiMethod, $data);
    }

    private function createScenarioResult(string $actionApiMethod, array $data): ScenarioResult
    {
        return new ScenarioResult(
            $actionApiMethod,
            Request::METHOD_POST,
            $data
        );
    }

    private function getRandomFileAnotherUsers(string $username): ?TelegramFile
    {
        $repository = $this->entityManager->getRepository(TelegramFile::class);

        return $repository->getRandomFileAnotherUsers($username);
    }
}