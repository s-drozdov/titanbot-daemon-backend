<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Backend\PublicKey;

use Titanbot\Daemon\Application\Bus\Query\QueryResultInterface;

final readonly class BackendPublicKeyGetQueryResult implements QueryResultInterface
{
    public function __construct(
        public string $public_key,
    ) {
        /*_*/
    }
}
