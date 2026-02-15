<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Resources\doctrine\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260215093516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ssh (public VARCHAR(255) NOT NULL, private LONGTEXT NOT NULL, port INT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_EE8DCC4443915DCC (port), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE devices ADD ssh_uuid BINARY(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE devices ADD CONSTRAINT FK_11074E9A34A2D93B FOREIGN KEY (ssh_uuid) REFERENCES ssh (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11074E9A34A2D93B ON devices (ssh_uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devices DROP FOREIGN KEY FK_11074E9A34A2D93B');
        $this->addSql('DROP INDEX UNIQ_11074E9A34A2D93B ON devices');
        $this->addSql('DROP TABLE ssh');
        $this->addSql('ALTER TABLE devices DROP ssh_uuid');
    }
}
