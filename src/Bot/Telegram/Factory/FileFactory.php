<?php

namespace App\Bot\Telegram\Factory;

use App\Bot\Telegram\Model\File;
use App\Entity\TelegramFile;

class FileFactory
{
    private const UNSUPPORTED_TYPE = 'unsupported';

    public function createFileFromResponse(array $data): File
    {
        return new File(
            $this->extractType($data),
            $this->extractFileParameterByName($data, 'file_id'),
            $this->extractUsername($data),
            $this->extractFileParameterByName($data, 'file_unique_id')
        );
    }

    private function extractUsername(array $data): string
    {
        return $data['from']['username'];
    }

    private function extractType(array $data): string
    {
        if (isset($data[TelegramFile::TYPE_VIDEO])) {
            return TelegramFile::TYPE_VIDEO;
        }

        if (isset($data[TelegramFile::TYPE_VIDEO_NOTE])) {
            return TelegramFile::TYPE_VIDEO_NOTE;
        }

        return self::UNSUPPORTED_TYPE;
    }

    private function extractFileParameterByName(array $data, string $paramName): string
    {
        if (isset($data[TelegramFile::TYPE_VIDEO])) {
            return $data[TelegramFile::TYPE_VIDEO][$paramName];
        }

        if (isset($data[TelegramFile::TYPE_VIDEO_NOTE])) {
            return $data[TelegramFile::TYPE_VIDEO_NOTE][$paramName];
        }

        return '';
    }
}