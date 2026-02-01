<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\Device\Legion;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Domain\Repository\Filter\LegionFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Domain\Repository\LegionRepositoryInterface;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;

/**
 * @extends EntityRepository<Legion>
 */
final class LegionRepository extends EntityRepository implements LegionRepositoryInterface
{
    /** @use DoctrinePersistable<Legion> */
    use DoctrinePersistable;

    /** @use Paginable<Legion> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Legion::class));
    }
    
    #[Override]
    public function findByFilter(LegionFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('l');

        if ($filter->title !== null && $filter->title !== '') {
            $qb
                ->andWhere('l.title = :title')
                ->setParameter('title', $filter->title, Types::STRING)
            ;
        }

        if ($filter->payDayOfMonth !== null) {
            $qb
                ->andWhere('l.payDayOfMonth = :payDayOfMonth')
                ->setParameter('payDayOfMonth', $filter->payDayOfMonth, Types::INTEGER)
            ;
        }

        /** @var PaginationResult<Legion> $result */
        $result = $this->paginate($qb, $filter, Legion::class, 'l');

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
        return Legion::class;
    }
}
