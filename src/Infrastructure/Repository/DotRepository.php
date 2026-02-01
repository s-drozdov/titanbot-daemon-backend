<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Dot;
use Titanbot\Daemon\Domain\Repository\Filter\DotFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Domain\Repository\DotRepositoryInterface;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;

/**
 * @extends EntityRepository<Dot>
 */
final class DotRepository extends EntityRepository implements DotRepositoryInterface
{
    /** @use DoctrinePersistable<Dot> */
    use DoctrinePersistable;

    /** @use Paginable<Dot> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Dot::class));
    }
    
    #[Override]
    public function findByFilter(DotFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('d');

        if ($filter->x !== null) {
            $qb
                ->andWhere('d.x = :x')
                ->setParameter('x', $filter->x, Types::INTEGER)
            ;
        }

        if ($filter->y !== null) {
            $qb
                ->andWhere('d.y = :y')
                ->setParameter('y', $filter->y, Types::INTEGER)
            ;
        }

        /** @var PaginationResult<Dot> $result */
        $result = $this->paginate($qb, $filter, Dot::class, 'd');

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
        return Dot::class;
    }
}
