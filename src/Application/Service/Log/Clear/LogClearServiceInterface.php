<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Log\Clear;

interface LogClearServiceInterface
{
    public function perform(): void;
}
