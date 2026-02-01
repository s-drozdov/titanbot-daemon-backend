<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Domain\Repository\Filter\DeviceFilter;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;
use Titanbot\Daemon\Domain\Repository\DeviceRepositoryInterface;

/**
 * @extends EntityRepository<Device>
 */
final class DeviceRepository extends EntityRepository implements DeviceRepositoryInterface
{
    /** @use DoctrinePersistable<Device> */
    use DoctrinePersistable;

    /** @use Paginable<Device> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Device::class));
    }
    
    #[Override]
    public function findByFilter(DeviceFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('d');

        if ($filter->physicalId !== null) {
            $qb
                ->andWhere('d.physicalId = :physicalId')
                ->setParameter('physicalId', $filter->physicalId, Types::INTEGER)
            ;
        }

        /** @var PaginationResult<Device> $result */
        $result = $this->paginate($qb, $filter, Device::class, 'd');

        return $result;
    }

    #[Override]
    private function getStringHelper(): StringHelperInterface
    {
        return $this->stringHelper;
    }

    #[Override]
    private function getEntityFqcn(): string
    {
        return Device::class;
    }
}
