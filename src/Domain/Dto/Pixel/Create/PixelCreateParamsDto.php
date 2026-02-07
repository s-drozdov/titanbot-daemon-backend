<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Pixel\Create;

use Titanbot\Daemon\Domain\Dto\DtoInterface;

final readonly class PixelCreateParamsDto implements DtoInterface
{
    public function __construct(
        public int $x,
        public int $y,
        public string $rgbHex,
        public ?int $deviation,
    ) {
        /*_*/
    }
}
