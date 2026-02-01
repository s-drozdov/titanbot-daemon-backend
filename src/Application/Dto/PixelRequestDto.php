<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class PixelRequestDto implements DtoInterface
{
    public function __construct(
        public int $x,
        public int $y,
        public string $rgb_hex,
        public ?int $deviation = null,
    ) {
        /*_*/
    }
}
