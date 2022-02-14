<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220214150005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Prefill templates';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            INSERT INTO template (slug, content, mime) VALUES (
                'mobile-verfication', 'Your verification code is {{ code }}.', 'text/plain')
SQL);

        $this->addSql(<<<SQL
        INSERT INTO template (slug, content, mime) VALUES ('email-verfication', '
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Email verification</title>
                    <style>
                        .content {
                            margin: auto;
                            width: 600px;
                        }
                    </style>
                </head>
                <body>
                    <div class="content">
                        <p>Your verification code is {{ code }}.</p>
                    </div>
                </body>
                </html>',
                'text/html'
        );
SQL);

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM template WHERE slug = \'mobile-verfication\'');
        $this->addSql('DELETE FROM template WHERE slug = \'email-verfication\'');
    }
}
