<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Shape\Index;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Enum\ShapeType;

final readonly class ShapeIndexParamsDto implements DtoInterface
{
    public function __construct(
        public ?ShapeType $type = null,
        public ?int $x = null,
        public ?int $y = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?string $rgbHex = null,
        public ?int $size = null,
    ) {
        /*_*/
    }
}
