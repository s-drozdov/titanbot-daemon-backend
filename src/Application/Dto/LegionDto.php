<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class LegionDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public string $title,
        public ?string $ext_title,
        public ?int $pay_day_of_month,
    ) {
        /*_*/
    }
}
