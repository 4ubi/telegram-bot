<?php

namespace App\Entity;

use App\Repository\UserFilesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'user_files'), ORM\Entity(repositoryClass: UserFilesRepository::class)]
#[ORM\UniqueConstraint(name: 'user_files_file_id_user_id_system', columns: ['file_id', 'user_id', 'system'] )]
class UserFiles
{
    #[ORM\Id,ORM\Column(type: Types::INTEGER), ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(name: 'file_id', type: Types::STRING)]
    private string $fileId;

    #[ORM\Column(name: 'user_id', type: Types::STRING)]
    private string $userId;

    #[ORM\Column(name: 'system', type: Types::STRING)]
    private string $system;

    public function __construct()
    {
        $this->id     = null;
        $this->fileId = '';
        $this->userId = '';
        $this->system = '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): UserFiles
    {
        $this->id = $id;

        return $this;
    }

    public function getFileId(): string
    {
        return $this->fileId;
    }

    public function setFileId(string $fileId): UserFiles
    {
        $this->fileId = $fileId;

        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): UserFiles
    {
        $this->userId = $userId;

        return $this;
    }

    public function getSystem(): string
    {
        return $this->system;
    }

    public function setSystem(string $system): UserFiles
    {
        $this->system = $system;

        return $this;
    }
}