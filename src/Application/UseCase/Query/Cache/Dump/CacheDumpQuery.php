<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Cache\Dump;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class CacheDumpQuery implements QueryInterface
{
    public function __construct(
        public string $key,
    ) {
        /*_*/
    }
}
