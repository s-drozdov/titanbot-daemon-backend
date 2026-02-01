<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Log\Index;

use Titanbot\Daemon\Application\Dto\LogDto;
use Titanbot\Daemon\Library\Collection\ListInterface;

interface LogIndexGetServiceInterface
{
    /**
     * @return ListInterface<LogDto>
     */
    public function perform(?string $message): ListInterface;
}
