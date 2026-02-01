<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Cache\HealthCheck;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Application\Service\Cache\HealthCheck\CacheHealthCheckServiceInterface;
use Titanbot\Daemon\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQuery;
use Titanbot\Daemon\Application\UseCase\Query\Cache\HealthCheck\CacheHealthCheckQueryResult;

/**
 * @implements QueryHandlerInterface<CacheHealthCheckQuery,CacheHealthCheckQueryResult>
 */
final readonly class CacheHealthCheckQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CacheHealthCheckServiceInterface $cacheHealthCheckService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): CacheHealthCheckQueryResult
    {
        $this->cacheHealthCheckService->perform();

        return new CacheHealthCheckQueryResult();
    }
}
