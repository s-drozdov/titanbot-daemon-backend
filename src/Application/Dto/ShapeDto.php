<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class ShapeDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
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
