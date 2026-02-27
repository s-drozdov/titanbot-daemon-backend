<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity\Habit;

use Override;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Domain\Enum\ShapeType;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class Shape implements EntityInterface
{
    /** @var Collection<array-key,Habit> $habitList */
    private Collection $habitList;

    public function __construct(
        private UuidInterface $uuid,
        private ShapeType $type,
        private int $x,
        private int $y,
        private int $width,
        private int $height,
        private string $rgbHex,
        private int $size,
    ) {
        $this->habitList = new ArrayCollection();
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getType(): ShapeType
    {
        return $this->type;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getRgbHex(): string
    {
        return $this->rgbHex;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return Collection<array-key,Habit>
     */
    public function getHabitList(): Collection
    {
        return $this->habitList;
    }
}
