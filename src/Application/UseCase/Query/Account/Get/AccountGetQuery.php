<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Account\Get;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class AccountGetQuery implements QueryInterface
{
    public function __construct(
        public UuidInterface $uuid,
    ) {
        /*_*/
    }
}
