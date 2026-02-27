<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Shape\Create;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Enum\ShapeType;

final readonly class ShapeCreateParamsDto implements DtoInterface
{
    public function __construct(
        public ShapeType $type,
        public int $x,
        public int $y,
        public int $width,
        public int $height,
        public string $rgbHex,
        public int $size,
    ) {
        /*_*/
    }
}
