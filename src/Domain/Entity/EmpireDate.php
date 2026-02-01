<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class EmpireDate implements EntityInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private DateTimeImmutable $date,
    ) {
        /*_*/
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
