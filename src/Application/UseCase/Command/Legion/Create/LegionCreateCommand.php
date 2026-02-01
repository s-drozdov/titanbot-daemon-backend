<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Legion\Create;

use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class LegionCreateCommand implements CommandInterface
{
    public function __construct(
        public string $title,
        public ?string $ext_title,
        public ?int $pay_day_of_month,
    ) {
        /*_*/
    }
}