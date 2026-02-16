<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

use DateTimeImmutable;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class HabitDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public string $action,

        /** @var ListInterface<PixelDto> $pixelList */
        public ListInterface $pixelList,

        public bool $is_active,
        public ?DateTimeImmutable $updated_at,
        public ?int $account_logical_id = null,
        public ?int $priority = null,
        public ?string $trigger_ocr = null,
        public ?string $trigger_shell = null,
        public ?string $log_template = null,
        public ?int $post_timeout_ms = null,
        public ?string $comment = null,
    ) {
        /*_*/
    }
}
