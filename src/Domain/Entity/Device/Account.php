<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Entity\Device;

use Override;
use DateTimeImmutable;
use Titanbot\Daemon\Domain\Enum\Gender;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;

/**
 * @psalm-suppress ClassMustBeFinal [INFO] The class cannot be final because it is used as a it is used as a test double in PHPUnit and has no personal interface
 */
class Account implements EntityInterface
{
    /** @var Collection<array-key,Device> $deviceList */ 
    private Collection $deviceList;

    /** @var Collection<array-key,Device> $currentDeviceList */ 
    private Collection $currentDeviceList;

    private ?Legion $legion = null;

    public function __construct(
        private UuidInterface $uuid,
        private int $logicalId,
        private string $firstName,
        private string $lastName,
        private DateTimeImmutable $birthDate,
        private Gender $gender,
        private string $googleLogin,
        private string $googlePassword,
    ) {
        $this->deviceList = new ArrayCollection();
        $this->currentDeviceList = new ArrayCollection();
    }

    #[Override]
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /** 
     * @return Collection<array-key,Device> 
     */ 
    public function getDeviceList(): Collection
    {
        return $this->deviceList;
    }

    /** 
     * @param Collection<array-key,Device> $deviceList
     */ 
    public function setDeviceList(Collection $deviceList): self
    {
        $this->deviceList = $deviceList;

        return $this;
    }

    /** 
     * @return Collection<array-key,Device> 
     */ 
    public function getCurrentDeviceList(): Collection
    {
        return $this->currentDeviceList;
    }

    /** 
     * @param Collection<array-key,Device> $currentDeviceList
     */ 
    public function setCurrentDeviceList(Collection $currentDeviceList): self
    {
        $this->currentDeviceList = $currentDeviceList;

        return $this;
    }

    public function getLegion(): ?Legion
    {
        return $this->legion;
    }

    public function setLegion(?Legion $legion): self
    {
        $this->legion = $legion;

        return $this;
    }

    public function getLogicalId(): int
    {
        return $this->logicalId;
    }

    public function setLogicalId(int $logicalId): self
    {
        $this->logicalId = $logicalId;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(DateTimeImmutable $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getGoogleLogin(): string
    {
        return $this->googleLogin;
    }

    public function setGoogleLogin(string $googleLogin): self
    {
        $this->googleLogin = $googleLogin;

        return $this;
    }

    public function getGooglePassword(): string
    {
        return $this->googlePassword;
    }

    public function setGooglePassword(string $googlePassword): self
    {
        $this->googlePassword = $googlePassword;

        return $this;
    }
}
