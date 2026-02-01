<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Repository;

use Override;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Domain\Helper\String\StringHelperInterface;
use Titanbot\Daemon\Infrastructure\Repository\Paginable;
use Titanbot\Daemon\Domain\Repository\Filter\AccountFilter;
use Titanbot\Daemon\Infrastructure\Repository\DoctrinePersistable;
use Titanbot\Daemon\Domain\Repository\AccountRepositoryInterface;

/**
 * @extends EntityRepository<Account>
 */
final class AccountRepository extends EntityRepository implements AccountRepositoryInterface
{
    /** @use DoctrinePersistable<Account> */
    use DoctrinePersistable;

    /** @use Paginable<Account> */
    use Paginable;

    public function __construct(
        EntityManagerInterface $entityManager,
        private StringHelperInterface $stringHelper,
    ) {
        parent::__construct($entityManager, $entityManager->getClassMetadata(Account::class));
    }
    
    #[Override]
    public function findByFilter(AccountFilter $filter): PaginationResult
    {
        $qb = $this->createQueryBuilder('a');

        if ($filter->logicalId !== null) {
            $qb
                ->andWhere('a.logicalId = :logicalId')
                ->setParameter('logicalId', $filter->logicalId, Types::INTEGER)
            ;
        }

        /** @var PaginationResult<Account> $result */
        $result = $this->paginate($qb, $filter, Account::class, 'a');

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
        return Account::class;
    }
}
