<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220214145058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create template table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE template (
            slug VARCHAR(255) NOT NULL,
            content text NOT NULL,
            mime VARCHAR(255) NOT NULL,
            PRIMARY KEY(slug))
       ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE template');
    }
}
