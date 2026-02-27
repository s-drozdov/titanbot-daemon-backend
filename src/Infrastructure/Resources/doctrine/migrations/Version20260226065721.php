<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Resources\doctrine\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260226065721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE habit_shapes (habit_uuid BINARY(16) NOT NULL, shape_uuid BINARY(16) NOT NULL, INDEX IDX_3E9D74563C898F92 (habit_uuid), INDEX IDX_3E9D7456FB274C16 (shape_uuid), PRIMARY KEY (habit_uuid, shape_uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE shapes (type VARCHAR(255) NOT NULL, x INT NOT NULL, y INT NOT NULL, width INT NOT NULL, height INT NOT NULL, rgb_hex VARCHAR(6) NOT NULL, size INT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX shape_unique (type, x, y, width, height, rgb_hex, size), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE habit_shapes ADD CONSTRAINT FK_3E9D74563C898F92 FOREIGN KEY (habit_uuid) REFERENCES habits (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habit_shapes ADD CONSTRAINT FK_3E9D7456FB274C16 FOREIGN KEY (shape_uuid) REFERENCES shapes (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habits DROP trigger_ocr');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habit_shapes DROP FOREIGN KEY FK_3E9D74563C898F92');
        $this->addSql('ALTER TABLE habit_shapes DROP FOREIGN KEY FK_3E9D7456FB274C16');
        $this->addSql('DROP TABLE habit_shapes');
        $this->addSql('DROP TABLE shapes');
        $this->addSql('ALTER TABLE habits ADD trigger_ocr VARCHAR(255) DEFAULT NULL');
    }
}
