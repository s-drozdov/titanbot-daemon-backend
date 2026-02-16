<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Service\Backend\PublicKey;

use Override;

final readonly class BackendPublicKeyGetService implements BackendPublicKeyGetServiceInterface
{
    public function __construct(
        private string $backendPublicKey,
    ) {
        /*_*/
    }

    #[Override]
    public function perform(): string
    {
        return $this->backendPublicKey;
    }
}
