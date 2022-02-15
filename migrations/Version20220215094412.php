<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220215094412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create verification table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE verification (
                id VARCHAR(255) NOT NULL,
                code VARCHAR(255) NOT NULL,
                confirmed BOOLEAN NOT NULL,
                expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                subject_identity VARCHAR(255) NOT NULL,
                subject_type VARCHAR(255) NOT NULL,
                user_info_ip VARCHAR(255) NOT NULL,
                user_info_user_agent VARCHAR(255) NOT NULL,
                PRIMARY KEY(id))
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE verification');
    }
}
