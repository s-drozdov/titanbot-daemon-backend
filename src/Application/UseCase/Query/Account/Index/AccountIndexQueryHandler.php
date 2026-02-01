<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Account\Index;

use Override;
use Titanbot\Daemon\Library\Collection\Map;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\AccountMapper;
use Titanbot\Daemon\Domain\Entity\Device\Account;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\Account\Index\AccountIndexServiceInterface;

/**
 * @implements QueryHandlerInterface<AccountIndexQuery,AccountIndexQueryResult>
 */
final readonly class AccountIndexQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AccountIndexServiceInterface $accountIndexService,

        /** @var AccountMapper $accountMapper */
        private AccountMapper $accountMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): AccountIndexQueryResult
    {
        $paginationResult = $this->accountIndexService->perform($query->logical_id);

        $mapValue = array_reduce(
            $paginationResult->items->toArray(), 
            function (array $result, Account $entity) {
                $result[(string) $entity->getUuid()] = $this->accountMapper->mapDomainObjectToDto($entity);

                return $result;
            }, 
            [],
        );

        return new AccountIndexQueryResult(
            uuid_to_account_map: new Map(
                value: $mapValue,
                innerType: $this->accountMapper->getDtoType(),
            ),
        );
    }
}
