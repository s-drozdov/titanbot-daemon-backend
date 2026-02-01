<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Domain\Repository\Filter\HabitFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Domain\Repository\HabitRepositoryInterface;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;

/**
 * @extends EntityRepository<Habit>
 */
final class HabitRepository extends EntityRepository implements HabitRepositoryInterface
{
    /** @use DoctrinePersistable<Habit> */
    use DoctrinePersistable;

    /** @use Paginable<Habit> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Habit::class));
    }

    #[Override]
    public function getVersion(?int $accountLogicalId): ?DateTimeImmutable
    {
        $qb = $this->createQueryBuilder('h');

        $qb->andWhere('h.accountLogicalId IS NULL');

        if ($accountLogicalId !== null) {
            $qb
                ->orWhere('h.accountLogicalId = :accountLogicalId')
                ->setParameter('accountLogicalId', $accountLogicalId, Types::INTEGER)
            ;
        }

        $qb
            ->select('h.updatedAt')
            ->orderBy('h.updatedAt', 'DESC')
            ->setMaxResults(1)
        ;

        try {
            return new DateTimeImmutable(
                (string) $qb->getQuery()->getSingleScalarResult(),
            );
        } catch (NoResultException) {}

        return null;
    }
    
    #[Override]
    public function findByFilter(HabitFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('h');

        if ($filter->accountLogicalId !== null) {
            $qb
                ->andWhere('h.accountLogicalId = :accountLogicalId')
                ->setParameter('accountLogicalId', $filter->accountLogicalId, Types::INTEGER)
            ;
        }

        if ($filter->isActive !== null) {
            $qb
                ->andWhere('h.isActive = :isActive')
                ->setParameter('isActive', $filter->isActive, Types::BOOLEAN)
            ;
        }

        if ($filter->action !== null) {
            $qb
                ->andWhere('h.action = :action')
                ->setParameter('action', $filter->action, Types::STRING)
            ;
        }

        /** @var PaginationResult<Habit> $result */
        $result = $this->paginate($qb, $filter, Habit::class, 'h');

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
        return Habit::class;
    }
}
