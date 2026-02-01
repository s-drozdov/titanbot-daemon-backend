<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\DaemonToken;

use Override;
use Webmozart\Assert\Assert;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;

final readonly class DaemonTokenFactory implements DaemonTokenFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
    ) {
        /*_*/
    }

    #[Override]
    public function create(string $token): DaemonToken
    {
        Assert::notEmpty($token);

        return new DaemonToken(
            uuid: $this->uuidHelper->create(),
            token: $token,
        );
    }
}
