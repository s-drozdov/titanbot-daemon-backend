<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Service\Ssh\Create;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;
use Titanbot\Daemon\Domain\Service\ServiceInterface;
use Titanbot\Daemon\Domain\Dto\Ssh\Create\SshCreateParamsDto;

interface SshCreateServiceInterface extends ServiceInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function perform(SshCreateParamsDto $paramsDto): Ssh;
}
