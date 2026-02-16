<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Backend\PublicKey;

interface BackendPublicKeyGetServiceInterface
{
    public function perform(): string;
}
