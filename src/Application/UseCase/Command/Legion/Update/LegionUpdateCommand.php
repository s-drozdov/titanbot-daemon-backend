<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Legion\Update;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class LegionUpdateCommand implements CommandInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public ?string $title,
        public ?string $ext_title,
        public ?int $pay_day_of_month,
    ) {
        /*_*/
    }
}
