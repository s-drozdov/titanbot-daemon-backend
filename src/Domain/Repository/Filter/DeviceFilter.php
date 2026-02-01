<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository\Filter;

use Override;
use Titanbot\Daemon\Library\Pager\PagerInterface;
use Titanbot\Daemon\Domain\Repository\Filter\FilterInterface;

final readonly class DeviceFilter implements FilterInterface
{
    public function __construct(
        public ?int $physicalId = null,
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
