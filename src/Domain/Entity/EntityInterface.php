<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity;

use Titanbot\Daemon\Domain\DomainObjectInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

interface EntityInterface extends DomainObjectInterface
{
    public function getUuid(): UuidInterface; 
}
