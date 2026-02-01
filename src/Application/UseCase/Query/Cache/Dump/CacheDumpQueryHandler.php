<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Cache\Dump;

use Override;
use Psr\SimpleCache\CacheInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Application\UseCase\Query\Cache\Dump\CacheDumpQuery;

/**
 * @implements QueryHandlerInterface<CacheDumpQuery,CacheDumpQueryResult>
 */
final readonly class CacheDumpQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CacheInterface $cache,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): CacheDumpQueryResult
    {
        dump($this->cache->get($query->key));

        return new CacheDumpQueryResult();
    }
}
