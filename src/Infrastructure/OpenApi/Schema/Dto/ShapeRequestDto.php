<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class ShapeRequestDto
{
    public string $type;

    public int $x;

    public int $y;

    public int $width;

    public int $height;

    public string $rgb_hex;

    public int $size;
}
