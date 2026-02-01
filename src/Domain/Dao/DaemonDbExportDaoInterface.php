<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dao;

interface DaemonDbExportDaoInterface
{
    public function createDaemonDbSchema(): void;

    /**
     * @return string[]
     */
    public function cloneHabits(?int $logicalId): array;

    /**
     * @param array<array-key,string> $habitUuidList
     * 
     * @return array<array-key,string>
     */
    public function cloneHabitPixels(array $habitUuidList): array;

    /**
     * @param string[] $pixelUuidList
     */
    public function clonePixelsWithRelatives(array $pixelUuidList): void;
}
