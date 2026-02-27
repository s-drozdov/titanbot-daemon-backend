<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository\Filter;

use Override;
use Titanbot\Daemon\Domain\Enum\ShapeType;
use Titanbot\Daemon\Library\Pager\PagerInterface;
use Titanbot\Daemon\Domain\Repository\Filter\FilterInterface;

final readonly class ShapeFilter implements FilterInterface
{
    public function __construct(
        public ?ShapeType $type = null,
        public ?int $x = null,
        public ?int $y = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?string $rgbHex = null,
        public ?int $size = null,
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
