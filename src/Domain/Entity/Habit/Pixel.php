<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity\Habit;

use Override;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class Pixel implements EntityInterface
{
    /** @var Collection<array-key,Habit> $habitList */ 
    private Collection $habitList;

    public function __construct(
        private UuidInterface $uuid,
        private Dot $dot,
        private Color $color,
    ) {
        $this->habitList = new ArrayCollection();
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getDot(): Dot
    {
        return $this->dot;
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    /**
     * @return Collection<array-key,Habit>
     */
    public function getHabitList(): Collection
    {
        return $this->habitList;
    }
}
