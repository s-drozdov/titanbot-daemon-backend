<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Repository\Filter\EmpireDateFilter;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;
use Titanbot\Daemon\Domain\Repository\EmpireDateRepositoryInterface;

/**
 * @extends EntityRepository<EmpireDate>
 */
final class EmpireDateRepository extends EntityRepository implements EmpireDateRepositoryInterface
{
    /** @use DoctrinePersistable<EmpireDate> */
    use DoctrinePersistable;

    /** @use Paginable<EmpireDate> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(EmpireDate::class));
    }
    
    
    #[Override]
    public function findNext(DateTimeImmutable $now): ?EmpireDate
    {
        $entity = $this
            ->createQueryBuilder('ed')
            ->andWhere('ed.date > :now')
            ->setParameter('now', $now, Types::DATETIME_IMMUTABLE)
            ->orderBy('ed.date', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        /** @var ?EmpireDate $entity */
        return $entity;
    }
    
    #[Override]
    public function findByFilter(EmpireDateFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('ed');

        if (!empty($filter->date)) {
            $qb
                ->andWhere('ed.date = :date')
                ->setParameter('date', $filter->date, Types::DATE_IMMUTABLE)
            ;
        }

        /** @var PaginationResult<EmpireDate> $result */
        $result = $this->paginate($qb, $filter, EmpireDate::class, 'ed');

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
        return EmpireDate::class;
    }
}
