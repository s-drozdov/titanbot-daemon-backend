<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Legion\Update;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

final readonly class LegionUpdateParamsDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public ?string $title,
        public ?string $extTitle,
        public ?int $payDayOfMonth,
    ) {
        /*_*/
    }
}
