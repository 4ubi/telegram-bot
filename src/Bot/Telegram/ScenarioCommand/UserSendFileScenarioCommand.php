<?php

namespace App\Bot\Telegram\ScenarioCommand;

use App\Bot\Telegram\Enum\BotScenarioCommandsEnum;
use App\Bot\Telegram\Model\File;
use App\Bot\Telegram\Model\Message;
use App\Bot\Telegram\TelegramBot;
use App\Entity\TelegramFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class UserSendFileScenarioCommand implements ScenarioCommandInterface
{
    private const TEXT_UNSUPPORTED_FILE = 'Нужно отправить подготовленное видео или сними кружок! Данный файл не поддерживается, попробуй еще раз.';
    private const TEXT_SUCCESS_FILE     = 'Твоя новость успешна добавлена, можешь отправить еще или завершить радовать';

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function support(Message $message): bool
    {
        return BotScenarioCommandsEnum::USER_SEND_FILE->value === $message->bodyMessage->textBody;
    }

    public function process(Message $message): ScenarioResult
    {
        $file = $message->bodyMessage->fileBody;

        if (!$this->supportFile($file)) {

            return new ScenarioResult(
                TelegramBot::SEND_MESSAGE_METHOD,
                Request::METHOD_POST,
                $this->createMessageData(
                    $message,
                    self::TEXT_UNSUPPORTED_FILE,
                    true,
                    BotScenarioCommandsEnum::USER_WANT_FINISHED_SEND_JOY
                )
            );
        }

        $this->saveFile($file);

        return new ScenarioResult(
            TelegramBot::SEND_MESSAGE_METHOD,
            Request::METHOD_POST,
            $this->createMessageData(
                $message,
                self::TEXT_SUCCESS_FILE,
                true,
                BotScenarioCommandsEnum::USER_WANT_FINISHED_SEND_JOY
            )
        );
    }

    private function createMessageData(
        Message $message,
        string $text,
        bool $needButton = false,
        ?BotScenarioCommandsEnum $buttonCommand = null
    ): array {
        $data = [
            'chat_id' => $message->chat->id,
            'text'    => $text,
        ];

        if ($needButton && $buttonCommand) {
            $data['reply_markup'] = [
                'resize_keyboard' => true,
                'keyboard'        => [
                    [
                        ['text' => $buttonCommand->value],
                    ],
                ],
            ];
        }

        return $data;
    }

    private function supportFile(File $file): bool
    {
        return in_array($file->type, [TelegramFile::TYPE_VIDEO_NOTE, TelegramFile::TYPE_VIDEO]);
    }

    private function saveFile(File $file): void
    {
        $telegramFile = $this->entityManager->getRepository(TelegramFile::class)->findOneBy(
            [
                'fileId'       => $file->fileId,
                'username'     => $file->username,
                'fileUniqueId' => $file->fileUniqueId,
            ]
        );

        if ($telegramFile) {
            return;
        }

        $telegramFile = (new TelegramFile())
            ->setType($file->type)
            ->setUsername($file->username)
            ->setFileId($file->fileId)
            ->setFileUniqueId($file->fileUniqueId);

        $this->entityManager->persist($telegramFile);
        $this->entityManager->flush();
    }
}