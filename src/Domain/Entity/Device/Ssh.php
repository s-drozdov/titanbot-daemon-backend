<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity\Device;

use Override;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class Ssh implements EntityInterface
{
    private ?Device $device = null;

    public function __construct(
        private UuidInterface $uuid,
        private string $public,
        private string $private,
        private int $port,
    ) {
        /*_*/
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(Device $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function getPublic(): string
    {
        return $this->public;
    }

    public function getPrivate(): string
    {
        return $this->private;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function setPort(int $port): self
    {
        $this->port = $port;

        return $this;
    }
}
