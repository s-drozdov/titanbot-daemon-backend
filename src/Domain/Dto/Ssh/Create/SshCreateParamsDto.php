<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Dto\Ssh\Create;

use Titanbot\Daemon\Domain\Dto\DtoInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

final readonly class SshCreateParamsDto implements DtoInterface
{
    public function __construct(
        public UuidInterface $deviceUuid,
        public string $public,
        public string $private,
        public ?int $port = null,
    ) {
        /*_*/
    }
}
