<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Index;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class DaemonTokenIndexQuery implements QueryInterface
{
    public function __construct(
        public ?string $token,
    ) {
        /*_*/
    }
}
