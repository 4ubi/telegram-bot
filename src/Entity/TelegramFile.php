<?php

namespace App\Entity;

use App\Repository\TelegramFileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'telegram_files'), ORM\Entity(repositoryClass: TelegramFileRepository::class)]
#[ORM\UniqueConstraint(name: 'user_files_file_id_user_id_system', columns: ['file_id', 'user_id', 'system'])]
class TelegramFile
{
    public const TYPE_VIDEO      = 'video';
    public const TYPE_VIDEO_NOTE = 'video_note';

    #[ORM\Id, ORM\Column(type: Types::INTEGER), ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(name: 'file_id', type: Types::STRING)]
    private string $fileId;

    #[ORM\Column(name: 'file_unique_id', type: Types::STRING)]
    private string $fileUniqueId;

    #[ORM\Column(name: 'username', type: Types::STRING)]
    private string $username;

    #[ORM\Column(name: 'type', type: Types::STRING)]
    private string $type;

    public function __construct()
    {
        $this->id           = null;
        $this->fileId       = '';
        $this->fileUniqueId = '';
        $this->username     = '';
        $this->type         = '';
    }

    public function getFileUniqueId(): string
    {
        return $this->getFileUniqueId();
    }

    public function setFileUniqueId($fileUniqueId): TelegramFile
    {
        $this->fileUniqueId = $fileUniqueId;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): TelegramFile
    {
        $this->id = $id;

        return $this;
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function setFileId(string $fileId): TelegramFile
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): TelegramFile
    {
        $this->username = $username;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): TelegramFile
    {
        $this->type = $type;

        return $this;
    }
}