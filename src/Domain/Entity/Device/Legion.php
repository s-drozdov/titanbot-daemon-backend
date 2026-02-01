<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity\Device;

use Override;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class Legion implements EntityInterface
{
    /** @var Collection<array-key,Account> $accountList */ 
    private Collection $accountList;

    public function __construct(
        private UuidInterface $uuid,
        private string $title,
        private ?string $extTitle,
        private ?int $payDayOfMonth,
    ) {
        $this->accountList = new ArrayCollection();
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getExtTitle(): ?string
    {
        return $this->extTitle;
    }

    public function setExtTitle(?string $extTitle): self
    {
        $this->extTitle = $extTitle;

        return $this;
    }

    public function getPayDayOfMonth(): ?int
    {
        return $this->payDayOfMonth;
    }

    public function setPayDayOfMonth(?int $payDayOfMonth): self
    {
        $this->payDayOfMonth = $payDayOfMonth;

        return $this;
    }
}
