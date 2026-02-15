<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Ssh;

use InvalidArgumentException;
use Titanbot\Daemon\Domain\Factory\FactoryInterface;
use Titanbot\Daemon\Domain\Dto\Ssh\Create\SshCreateParamsDto;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;

interface SshFactoryInterface extends FactoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function create(SshCreateParamsDto $paramsDto): Ssh;
}
