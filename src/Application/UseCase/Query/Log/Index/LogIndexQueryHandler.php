<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Log\Index;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Application\Service\Log\Index\LogIndexGetServiceInterface;

/**
 * @implements QueryHandlerInterface<LogIndexQuery,LogIndexQueryResult>
 */
final readonly class LogIndexQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LogIndexGetServiceInterface $logIndexGetService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): LogIndexQueryResult
    {
        return new LogIndexQueryResult(
            log_list: $this->logIndexGetService->perform($query->message),
        );
    }
}
