<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class PixelRequestDto
{
    public int $x;

    public int $y;

    public string $rgb_hex;

    public ?int $deviation = null;
}
