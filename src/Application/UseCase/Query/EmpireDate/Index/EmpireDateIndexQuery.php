<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Index;

use DateTimeImmutable;
use Titanbot\Daemon\Application\Bus\Query\QueryInterface;

final readonly class EmpireDateIndexQuery implements QueryInterface
{
    public function __construct(
        public ?DateTimeImmutable $date,
    ) {
        /*_*/
    }
}
