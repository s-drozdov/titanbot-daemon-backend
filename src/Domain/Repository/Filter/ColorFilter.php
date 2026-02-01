<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository\Filter;

use Override;
use Titanbot\Daemon\Library\Pager\PagerInterface;
use Titanbot\Daemon\Domain\Repository\Filter\FilterInterface;

final readonly class ColorFilter implements FilterInterface
{
    public function __construct(
        public ?string $rgbHex = null,
        public ?int $deviation = null,
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
