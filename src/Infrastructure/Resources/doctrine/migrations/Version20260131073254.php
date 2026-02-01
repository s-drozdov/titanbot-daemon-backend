<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Resources\doctrine\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260131073254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounts (logical_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, gender VARCHAR(255) NOT NULL, google_login VARCHAR(255) NOT NULL, google_password VARCHAR(255) NOT NULL, uuid BINARY(16) NOT NULL, legion_uuid BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_CAC89EACAD4915F9 (logical_id), INDEX IDX_CAC89EACF459A85C (legion_uuid), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE colors (rgb_hex VARCHAR(255) DEFAULT NULL, deviation INT DEFAULT 0 NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_C2BEC39F8366E63390A873F4 (rgb_hex, deviation), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE daemon_tokens (token VARCHAR(255) NOT NULL, uuid BINARY(16) NOT NULL, PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE devices (physical_id INT NOT NULL, is_active TINYINT NOT NULL, activity_type VARCHAR(255) NOT NULL, is_empire_sleeping TINYINT NOT NULL, is_full_server_detection TINYINT NOT NULL, is_able_to_clear_cache TINYINT NOT NULL, go_time_limit_seconds INT NOT NULL, uuid BINARY(16) NOT NULL, current_account_uuid BINARY(16) DEFAULT NULL, UNIQUE INDEX UNIQ_11074E9AF5A63AC0 (physical_id), INDEX IDX_11074E9AA25D69D7 (current_account_uuid), INDEX idx__devices__physical_id (physical_id), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE device_accounts (device_uuid BINARY(16) NOT NULL, account_uuid BINARY(16) NOT NULL, INDEX IDX_44FCC78C5846859C (device_uuid), INDEX IDX_44FCC78C5DECD70C (account_uuid), PRIMARY KEY (device_uuid, account_uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dots (x INT NOT NULL, y INT NOT NULL, uuid BINARY(16) NOT NULL, UNIQUE INDEX UNIQ_54D4AF218CDC1683FBDB2615 (x, y), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE empire_dates (date DATE NOT NULL, uuid BINARY(16) NOT NULL, PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE habits (account_logical_id INT DEFAULT NULL, priority INT DEFAULT NULL, trigger_ocr VARCHAR(255) DEFAULT NULL, trigger_shell VARCHAR(255) DEFAULT NULL, action VARCHAR(255) NOT NULL, is_active TINYINT NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, uuid BINARY(16) NOT NULL, PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE habit_pixels (habit_uuid BINARY(16) NOT NULL, pixel_uuid BINARY(16) NOT NULL, INDEX IDX_6357ED8F3C898F92 (habit_uuid), INDEX IDX_6357ED8F76762BF7 (pixel_uuid), PRIMARY KEY (habit_uuid, pixel_uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE legions (title VARCHAR(255) NOT NULL, ext_title VARCHAR(255) DEFAULT NULL, pay_day_of_month INT DEFAULT NULL, uuid BINARY(16) NOT NULL, PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE pixels (uuid BINARY(16) NOT NULL, dot_uuid BINARY(16) NOT NULL, color_uuid BINARY(16) NOT NULL, INDEX IDX_CE113CCB96B6D553 (dot_uuid), INDEX IDX_CE113CCBACA86BE2 (color_uuid), PRIMARY KEY (uuid)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE accounts ADD CONSTRAINT FK_CAC89EACF459A85C FOREIGN KEY (legion_uuid) REFERENCES legions (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE devices ADD CONSTRAINT FK_11074E9AA25D69D7 FOREIGN KEY (current_account_uuid) REFERENCES accounts (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE device_accounts ADD CONSTRAINT FK_44FCC78C5846859C FOREIGN KEY (device_uuid) REFERENCES devices (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE device_accounts ADD CONSTRAINT FK_44FCC78C5DECD70C FOREIGN KEY (account_uuid) REFERENCES accounts (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habit_pixels ADD CONSTRAINT FK_6357ED8F3C898F92 FOREIGN KEY (habit_uuid) REFERENCES habits (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE habit_pixels ADD CONSTRAINT FK_6357ED8F76762BF7 FOREIGN KEY (pixel_uuid) REFERENCES pixels (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pixels ADD CONSTRAINT FK_CE113CCB96B6D553 FOREIGN KEY (dot_uuid) REFERENCES dots (uuid)');
        $this->addSql('ALTER TABLE pixels ADD CONSTRAINT FK_CE113CCBACA86BE2 FOREIGN KEY (color_uuid) REFERENCES colors (uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE accounts DROP FOREIGN KEY FK_CAC89EACF459A85C');
        $this->addSql('ALTER TABLE devices DROP FOREIGN KEY FK_11074E9AA25D69D7');
        $this->addSql('ALTER TABLE device_accounts DROP FOREIGN KEY FK_44FCC78C5846859C');
        $this->addSql('ALTER TABLE device_accounts DROP FOREIGN KEY FK_44FCC78C5DECD70C');
        $this->addSql('ALTER TABLE habit_pixels DROP FOREIGN KEY FK_6357ED8F3C898F92');
        $this->addSql('ALTER TABLE habit_pixels DROP FOREIGN KEY FK_6357ED8F76762BF7');
        $this->addSql('ALTER TABLE pixels DROP FOREIGN KEY FK_CE113CCB96B6D553');
        $this->addSql('ALTER TABLE pixels DROP FOREIGN KEY FK_CE113CCBACA86BE2');
        $this->addSql('DROP TABLE accounts');
        $this->addSql('DROP TABLE colors');
        $this->addSql('DROP TABLE daemon_tokens');
        $this->addSql('DROP TABLE devices');
        $this->addSql('DROP TABLE device_accounts');
        $this->addSql('DROP TABLE dots');
        $this->addSql('DROP TABLE empire_dates');
        $this->addSql('DROP TABLE habits');
        $this->addSql('DROP TABLE habit_pixels');
        $this->addSql('DROP TABLE legions');
        $this->addSql('DROP TABLE pixels');
    }
}
