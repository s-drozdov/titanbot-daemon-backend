<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity\Device;

use Override;
use Doctrine\Common\Collections\Collection;
use Titanbot\Daemon\Domain\Entity\Eventable;
use Titanbot\Daemon\Domain\Enum\ActivityType;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Domain\Entity\AggregateInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class Device implements AggregateInterface
{
    use Eventable;

    private ?Account $currentAccount = null;

    private ?Ssh $ssh = null;

    /** @var Collection<array-key,Account> $accountList */ 
    private Collection $accountList;
    
    public function __construct(
        private UuidInterface $uuid,
        private int $physicalId,
        private bool $isActive,
        private bool $isSsh,
        private bool $isNeedToUpdate,
        private ActivityType $activityType,
        private bool $isFullServerDetection,
        private bool $isAbleToClearCache,
        private int $goTimeLimitSeconds,
    ) {
        $this->accountList = new ArrayCollection();
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getPhysicalId(): int
    {
        return $this->physicalId;
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

    public function isSsh(): bool
    {
        return $this->isSsh;
    }

    public function setIsSsh(bool $isSsh): self
    {
        $this->isSsh = $isSsh;

        return $this;
    }

    public function isNeedToUpdate(): bool
    {
        return $this->isNeedToUpdate;
    }

    public function setIsNeedToUpdate(bool $isNeedToUpdate): self
    {
        $this->isNeedToUpdate = $isNeedToUpdate;

        return $this;
    }

    public function getActivityType(): ActivityType
    {
        return $this->activityType;
    }

    public function setActivityType(ActivityType $activityType): self
    {
        $this->activityType = $activityType;

        return $this;
    }

    public function isFullServerDetection(): bool
    {
        return $this->isFullServerDetection;
    }

    public function setIsFullServerDetection(bool $isFullServerDetection): self
    {
        $this->isFullServerDetection = $isFullServerDetection;

        return $this;
    }

    public function isAbleToClearCache(): bool
    {
        return $this->isAbleToClearCache;
    }

    public function setIsAbleToClearCache(bool $isAbleToClearCache): self
    {
        $this->isAbleToClearCache = $isAbleToClearCache;

        return $this;
    }

    public function getGoTimeLimitSeconds(): int
    {
        return $this->goTimeLimitSeconds;
    }

    public function setGoTimeLimitSeconds(int $goTimeLimitSeconds): self
    {
        $this->goTimeLimitSeconds = $goTimeLimitSeconds;

        return $this;
    }

    public function getCurrentAccount(): ?Account
    {
        return $this->currentAccount;
    }

    public function setCurrentAccount(?Account $currentAccount): self
    {
        $this->currentAccount = $currentAccount;

        return $this;
    }

    /** 
     * @return Collection<array-key,Account>
     */ 
    public function getAccountList(): Collection
    {
        return $this->accountList;
    }

    /** 
     * @param Collection<array-key,Account> $accountList
     */ 
    public function setAccountList(Collection $accountList): self
    {
        $this->accountList = $accountList;

        return $this;
    }

    public function getSsh(): ?Ssh
    {
        return $this->ssh;
    }

    public function setSsh(?Ssh $ssh): self
    {
        $this->ssh = $ssh;

        return $this;
    }
}
