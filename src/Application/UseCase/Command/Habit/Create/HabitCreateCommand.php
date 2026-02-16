<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Habit\Create;

use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Application\Bus\Command\CommandInterface;

final readonly class HabitCreateCommand implements CommandInterface
{
    public function __construct(
        public string $action,

        /** @var ListInterface<PixelRequestDto>|null $pixel_list */
        public ?ListInterface $pixel_list = null,

        public ?int $account_logical_id = null,
        public ?int $priority = null,
        public ?string $trigger_ocr = null,
        public ?string $trigger_shell = null,
        public ?string $log_template = null,
        public ?int $post_timeout_ms = null,
        public ?string $comment = null,
        public ?int $sequence = null,
        public ?string $context = null,
        public bool $is_active = true,
    ) {
        /*_*/
    }
}
