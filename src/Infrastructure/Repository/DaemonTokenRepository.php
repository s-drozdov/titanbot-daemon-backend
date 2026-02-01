<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Domain\Repository\Filter\DaemonTokenFilter;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;
use Titanbot\Daemon\Domain\Repository\DaemonTokenRepositoryInterface;

/**
 * @extends EntityRepository<DaemonToken>
 */
final class DaemonTokenRepository extends EntityRepository implements DaemonTokenRepositoryInterface
{
    /** @use DoctrinePersistable<DaemonToken> */
    use DoctrinePersistable;

    /** @use Paginable<DaemonToken> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(DaemonToken::class));
    }

    #[Override]
    public function findByFilter(DaemonTokenFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('dt');

        if ($filter->token !== null && $filter->token !== '') {
            $qb
                ->andWhere('dt.token = :token')
                ->setParameter('token', $filter->token, Types::STRING)
            ;
        }

        /** @var PaginationResult<DaemonToken> $result */
        $result = $this->paginate($qb, $filter, DaemonToken::class, 'dt');

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
        return DaemonToken::class;
    }
}
