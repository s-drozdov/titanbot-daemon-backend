<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository\Filter;

use DateTimeImmutable;
use Override;
use Titanbot\Daemon\Library\Pager\PagerInterface;
use Titanbot\Daemon\Domain\Repository\Filter\FilterInterface;

final readonly class EmpireDateFilter implements FilterInterface
{
    public function __construct(
        public ?DateTimeImmutable $date = null,
        public ?PagerInterface $pager = null,
    ) {
        /*_*/
    }

    #[Override]
    public function getPager(): ?PagerInterface
    {
        return $this->pager;
    }
}
