<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20221003135126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE telegram_files_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE telegram_files(
                        id integer not null ,
                        file_unique_id varchar(255) not null,
                        type varchar(100) not null,
                        file_id varchar(255) not null ,
                        username varchar(255) not null ,
                        primary key (id))'
        );
        $this->addSql('CREATE UNIQUE INDEX telegram_user_file_file_id_user_id on telegram_files (file_id, username, type)');

    }

    public function down(Schema $schema): void
    {
       $this->addSql('DROP SEQUENCE telegram_files_id_seq CASCADE');
       $this->addSql('DROP TABLE telegram_files');
    }
}
