<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\EmpireDate\GetNext;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Helper\DateTime\DateTimeHelperInterface;
use Titanbot\Daemon\Domain\Service\EmpireDate\GetNext\EmpireDateNextGetServiceInterface;

/**
 * @implements QueryHandlerInterface<EmpireDateNextGetQuery,EmpireDateNextGetQueryResult>
 */
final readonly class EmpireDateNextGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmpireDateNextGetServiceInterface $empireDateNextGetService,
        private DateTimeHelperInterface $dateTimeHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): EmpireDateNextGetQueryResult
    {
        $entity = $this->empireDateNextGetService->perform();

        return new EmpireDateNextGetQueryResult(
            unix_timestamp: $this->dateTimeHelper->getNextEmpireLimitUnixTs(
                $entity?->getDate(),
            ),
        );
    }
}
