<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto;

use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
readonly class SshDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $uuid,
        public int $physical_id,
        public string $public,
        public string $private,
        public int $server_device_internal_port,
        public string $server_name,
        public string $server_ip,
        public int $server_common_port,
    ) {
        /*_*/
    }
}
