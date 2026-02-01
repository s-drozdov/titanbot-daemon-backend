<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\EmpireDate\GetNext;

use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Entity\EmpireDate;

interface EmpireDateNextGetServiceInterface extends ServiceInterface
{
    public function perform(): ?EmpireDate;
}
