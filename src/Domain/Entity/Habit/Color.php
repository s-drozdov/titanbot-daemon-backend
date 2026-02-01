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
class Color implements EntityInterface
{
    /** @var Collection<array-key,Pixel> $pixelList */
    private Collection $pixelList;
    
    public function __construct(
        private UuidInterface $uuid,
        private string $rgbHex,
        private int $deviation,
    ) {
        $this->pixelList = new ArrayCollection();
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getRgbHex(): string
    {
        return $this->rgbHex;
    }

    public function getDeviation(): int
    {
        return $this->deviation;
    }

    /**
     * @return Collection<array-key,Pixel>
     */
    public function getPixelList(): Collection
    {
        return $this->pixelList;
    }
}
