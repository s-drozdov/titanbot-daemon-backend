<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Repository;

use Titanbot\Daemon\Domain\Entity\Device\Ssh;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Domain\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Ssh>
 */
interface SshRepositoryInterface extends RepositoryInterface
{
    /**
     * @return ListInterface<int>
     */
    public function findAllPorts(): ListInterface;

    public function save(Ssh $entity): void;
}
