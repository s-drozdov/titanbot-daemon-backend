<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository\Filter;

use Titanbot\Daemon\Library\Pager\PagerInterface;

interface FilterInterface
{
    public function getPager(): ?PagerInterface;
}
