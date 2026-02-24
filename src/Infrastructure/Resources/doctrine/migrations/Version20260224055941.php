<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Resources\doctrine\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260224055941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_EE8DCC4443915DCC ON ssh');
        $this->addSql('ALTER TABLE ssh CHANGE port server_device_internal_port INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EE8DCC44407C4FC3 ON ssh (server_device_internal_port)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_EE8DCC44407C4FC3 ON ssh');
        $this->addSql('ALTER TABLE ssh CHANGE server_device_internal_port port INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EE8DCC4443915DCC ON ssh (port)');
    }
}
