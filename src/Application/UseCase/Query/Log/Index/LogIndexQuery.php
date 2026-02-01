<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Log\Index;

use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class LogIndexQuery implements QueryInterface
{
    public function __construct(
        public ?string $message,
    ) {
        /*_*/
    }
}
