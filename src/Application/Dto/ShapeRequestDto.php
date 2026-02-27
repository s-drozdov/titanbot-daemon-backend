<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class ShapeRequestDto implements DtoInterface
{
    public function __construct(
        public string $type,
        public int $x,
        public int $y,
        public int $width,
        public int $height,
        public string $rgb_hex,
        public int $size,
    ) {
        /*_*/
    }
}
