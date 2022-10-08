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
        $this->addSql('CREATE SEQUENCE user_files_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_files(id integer not null , file_id varchar(255) not null , user_id varchar(255) not null , system varchar(100) not null, primary key (id))');
        $this->addSql('CREATE UNIQUE INDEX telegram_user_file_file_id_user_id on user_files (file_id, user_id, system)');

    }

    public function down(Schema $schema): void
    {
       $this->addSql('DROP SEQUENCE user_files_id_seq CASCADE');
       $this->addSql('DROP TABLE user_files');
    }
}
