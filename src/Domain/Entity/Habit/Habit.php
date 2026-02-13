<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity\Habit;

use Override;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Titanbot\Daemon\Domain\Entity\Eventable;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Domain\Entity\AggregateInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class Habit implements AggregateInterface
{
    use Eventable;

    /** @var Collection<array-key,Pixel> $pixelList */ 
    private Collection $pixelList;
    
    public function __construct(
        private UuidInterface $uuid,
        private ?int $accountLogicalId,
        private ?int $priority,
        private ?string $triggerOcr,
        private ?string $triggerShell,
        private ?string $logTemplate,
        private string $action,
        private bool $isActive,
        private DateTimeImmutable $updatedAt,
    ) {
        $this->pixelList = new ArrayCollection();
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getAccountLogicalId(): ?int
    {
        return $this->accountLogicalId;
    }

    public function setAccountLogicalId(?int $accountLogicalId): self
    {
        $this->accountLogicalId = $accountLogicalId;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getTriggerOcr(): ?string
    {
        return $this->triggerOcr;
    }

    public function setTriggerOcr(?string $triggerOcr): self
    {
        $this->triggerOcr = $triggerOcr;

        return $this;
    }

    public function getTriggerShell(): ?string
    {
        return $this->triggerShell;
    }

    public function setTriggerShell(?string $triggerShell): self
    {
        $this->triggerShell = $triggerShell;

        return $this;
    }

    public function getLogTemplate(): ?string
    {
        return $this->logTemplate;
    }

    public function setLogTemplate(?string $logTemplate): self
    {
        $this->logTemplate = $logTemplate;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<array-key,Pixel>
     */
    public function getPixelList(): Collection
    {
        return $this->pixelList;
    }

    /**
     * @param Collection<array-key,Pixel> $pixelList
     */
    public function setPixelList(Collection $pixelList): self
    {
        $this->pixelList = $pixelList;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }
}
