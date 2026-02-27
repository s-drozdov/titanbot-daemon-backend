<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Service\DaemonDb\Get;

use Override;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Titanbot\Daemon\Infrastructure\Dao\DaemonDbExportDao;
use Titanbot\Daemon\Domain\Dao\DaemonDbExportDaoInterface;
use Titanbot\Daemon\Domain\Service\DaemonDb\Get\DaemonDbGetServiceInterface;

final readonly class DaemonDbGetService implements DaemonDbGetServiceInterface
{
    private DaemonDbExportDaoInterface $daemonDbExportDao;

    private string $dbFile;

    public function __construct(
        Connection $mainConnection,
        string $daemonDbDriver,
    ) {
        $this->dbFile = sprintf(
            '%s/export_%s.db', 
            sys_get_temp_dir(), 
            bin2hex(random_bytes(8)),
        );

        /** 
         * @psalm-suppress ArgumentTypeCoercion [INFO]
         * @phpstan-ignore-next-line argument.type
         */
        $daemonDbConnection = DriverManager::getConnection([
            'driver' => $daemonDbDriver,
            'path' => $this->dbFile,
        ]);

        $this->daemonDbExportDao = new DaemonDbExportDao($mainConnection, $daemonDbConnection);
    }

    #[Override]
    public function perform(?int $accountLogicalId): string
    {
        $this->daemonDbExportDao->createDaemonDbSchema();

        $habitUuidList = $this->daemonDbExportDao->cloneHabits($accountLogicalId);

        if (empty($habitUuidList)) {
            return $this->dbFile;
        }

        $pixelUuidList = $this->daemonDbExportDao->cloneHabitPixels($habitUuidList);

        if (!empty($pixelUuidList)) {
            $this->daemonDbExportDao->clonePixelsWithRelatives($pixelUuidList);
        }

        $shapeUuidList = $this->daemonDbExportDao->cloneHabitShapes($habitUuidList);

        if (!empty($shapeUuidList)) {
            $this->daemonDbExportDao->cloneShapes($shapeUuidList);
        }

        return $this->dbFile;
    }
}
