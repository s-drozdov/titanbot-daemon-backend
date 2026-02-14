<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Dao;

use Override;
use Doctrine\DBAL\Result;
use Webmozart\Assert\Assert;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ArrayParameterType;
use Titanbot\Daemon\Domain\Dao\DaemonDbExportDaoInterface;

final class DaemonDbExportDao implements DaemonDbExportDaoInterface
{
    public function __construct(
        private Connection $mainConnection,
        private Connection $daemonDbConnection,
    ) {
        /*_*/
    }

    #[Override]
    public function createDaemonDbSchema(): void
    {
        $this->daemonDbConnection->executeStatement(<<<SQL
            CREATE TABLE habits (
                uuid BLOB NOT NULL,
                is_active INTEGER NOT NULL CHECK (is_active IN (0, 1)),
                account_logical_id INTEGER,
                priority INTEGER,
                trigger_ocr TEXT,
                trigger_shell TEXT,
                log_template TEXT,
                post_timeout_ms INTEGER,
                action TEXT NOT NULL,
                updated_at TEXT NOT NULL,
                PRIMARY KEY (uuid)
            );
        SQL);

        $this->daemonDbConnection->executeStatement(<<<SQL
            CREATE TABLE habit_pixels (
                habit_uuid BLOB NOT NULL,
                pixel_uuid BLOB NOT NULL,
                PRIMARY KEY (habit_uuid, pixel_uuid)
            );
        SQL);

        $this->daemonDbConnection->executeStatement(<<<SQL
            CREATE TABLE pixels (
                uuid BLOB NOT NULL,
                dot_uuid BLOB NOT NULL,
                color_uuid BLOB NOT NULL,
                PRIMARY KEY (uuid)
            );
        SQL);

        $this->daemonDbConnection->executeStatement(<<<SQL
            CREATE TABLE dots (
                uuid BLOB NOT NULL,
                x INTEGER NOT NULL,
                y INTEGER NOT NULL,
                PRIMARY KEY (uuid)
            );
        SQL);

        $this->daemonDbConnection->executeStatement(<<<SQL
            CREATE TABLE colors (
                uuid BLOB NOT NULL,
                rgb_hex TEXT NOT NULL,
                deviation INTEGER,
                PRIMARY KEY (uuid)
            );
        SQL);
    }

    /**
     * @return string[]
     */
    #[Override]
    public function cloneHabits(?int $logicalId): array
    {
        $habitUuidList = [];

        $result = $this->getResult($logicalId);

        while ($row = $result->fetchAssociative()) {
            Assert::string($row['uuid']);
            Assert::integer($row['is_active']);
            Assert::string($row['updated_at']);

            $this->daemonDbConnection->insert('habits', [
                'uuid' => $row['uuid'],
                'is_active' => $row['is_active'],
                'account_logical_id' => $row['account_logical_id'],
                'priority' => $row['priority'],
                'trigger_ocr' => $row['trigger_ocr'],
                'trigger_shell' => $row['trigger_shell'],
                'log_template' => $row['log_template'],
                'post_timeout_ms' => $row['post_timeout_ms'],
                'action' => $row['action'],
                'updated_at' => $row['updated_at'],
            ]);

            $habitUuidList[] = $row['uuid'];
        }

        return $habitUuidList;
    }
    
    #[Override]
    public function cloneHabitPixels(array $habitUuidList): array
    {
        $pixelUuidList = [];

        $result = $this->mainConnection->executeQuery(
            <<<SQL
            SELECT habit_uuid, pixel_uuid
            FROM habit_pixels
            WHERE habit_uuid IN (:habit_uuidList)
            SQL,
            ['habit_uuidList' => $habitUuidList],
            ['habit_uuidList' => ArrayParameterType::BINARY],
        );

        while ($row = $result->fetchAssociative()) {
            $this->daemonDbConnection->insert('habit_pixels', $row);
            Assert::string($row['pixel_uuid']);

            $pixelUuidList[] = $row['pixel_uuid'];
        }

        return array_values(
            array_unique($pixelUuidList),
        );
    }

    #[Override]
    public function clonePixelsWithRelatives(array $pixelUuidList): void
    {
        $dotUuidList = [];
        $colorUuidList = [];

        $this->clonePixels($pixelUuidList, $dotUuidList, $colorUuidList);
        
        $this->cloneDots(
            array_values(
                array_unique($dotUuidList),
            ),
        );

        $this->cloneColors(
            array_values(
                array_unique($colorUuidList),
            ),
        );
    }

    /**
     * @param array<array-key,string> $pixelUuidList
     * @param array<array-key,string> $dotUuidList
     * @param array<array-key,string> $colorUuidList
     */
    private function clonePixels(array $pixelUuidList, array &$dotUuidList, array &$colorUuidList): void
    {
        $result = $this->mainConnection->executeQuery(
            <<<SQL
            SELECT *
            FROM pixels
            WHERE uuid IN (:pixel_uuidList)
            SQL,
            ['pixel_uuidList' => $pixelUuidList],
            ['pixel_uuidList' => ArrayParameterType::BINARY],
        );

        while ($row = $result->fetchAssociative()) {
            $this->daemonDbConnection->insert('pixels', $row);

            Assert::string($row['dot_uuid']);
            Assert::string($row['color_uuid']);

            $dotUuidList[] = $row['dot_uuid'];
            $colorUuidList[] = $row['color_uuid'];
        }
    }

    /**
     * @param array<array-key,string> $dotUuidList
     */
    private function cloneDots(array $dotUuidList): void
    {
        if (empty($dotUuidList)) {
            return;
        }

        $result = $this->mainConnection->executeQuery(
            'SELECT * FROM dots WHERE uuid IN (:uuidList)',
            ['uuidList' => $dotUuidList],
            ['uuidList' => ArrayParameterType::BINARY],
        );

        while ($row = $result->fetchAssociative()) {
            $this->daemonDbConnection->insert('dots', $row);
        }
    }

    /**
     * @param array<array-key,string> $colorUuidList
     */
    private function cloneColors(array $colorUuidList): void
    {
        if (empty($colorUuidList)) {
            return;
        }

        $result = $this->mainConnection->executeQuery(
            'SELECT * FROM colors WHERE uuid IN (:uuidList)',
            ['uuidList' => $colorUuidList],
            ['uuidList' => ArrayParameterType::BINARY],
        );

        while ($row = $result->fetchAssociative()) {
            $this->daemonDbConnection->insert('colors', $row);
        }
    }

    /**
     * @return Result
     */
    private function getResult(?int $logicalId): Result
    {
        if ($logicalId === null) {
            return $this->mainConnection->executeQuery(
                <<<SQL
                SELECT *
                FROM habits
                WHERE account_logical_id IS NULL
                AND is_active = 1
                ORDER BY priority DESC
                SQL,
            );
        }

        return $this->mainConnection->executeQuery(
            <<<SQL
            SELECT *
            FROM habits
            WHERE (account_logical_id = :logical_id OR account_logical_id IS NULL)
            AND is_active = 1
            ORDER BY priority DESC
            SQL,
            ['logical_id' => $logicalId],
        );
    }
}
