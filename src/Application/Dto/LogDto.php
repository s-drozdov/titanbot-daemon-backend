<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class LogDto implements DtoInterface
{
    public function __construct(
        public string $message,
    ) {
        /*_*/
    }
}
