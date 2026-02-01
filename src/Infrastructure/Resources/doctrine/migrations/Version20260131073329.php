<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Resources\doctrine\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260131073329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Set updated_at in habits to current timestamp on update';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE habits MODIFY updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE habits MODIFY updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
