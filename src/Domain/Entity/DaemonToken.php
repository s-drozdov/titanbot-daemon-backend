<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity;

use Override;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class DaemonToken implements EntityInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private string $token,
    ) {
        /*_*/
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
