<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Account\Get;

use Override;
use InvalidArgumentException;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\AccountMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Titanbot\Daemon\Domain\Service\Account\Get\AccountGetServiceInterface;

/**
 * @implements QueryHandlerInterface<AccountGetQuery,AccountGetQueryResult>
 */
final readonly class AccountGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private AccountGetServiceInterface $accountGetService,

        /** @var AccountMapper $accountMapper */
        private AccountMapper $accountMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): AccountGetQueryResult
    {
        try {
            return new AccountGetQueryResult(
                account: $this->accountMapper->mapDomainObjectToDto(
                    $this->accountGetService->perform($query->uuid),
                ),
            );
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
