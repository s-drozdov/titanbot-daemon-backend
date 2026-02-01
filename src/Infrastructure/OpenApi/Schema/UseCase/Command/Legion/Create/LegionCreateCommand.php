<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Legion\Create;

use OpenApi\Attributes as OA;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class LegionCreateCommand
{
    public string $title;

    public ?string $ext_title;

    public ?int $pay_day_of_month;
}
