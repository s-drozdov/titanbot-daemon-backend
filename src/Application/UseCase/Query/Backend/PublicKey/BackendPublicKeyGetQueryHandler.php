<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Backend\PublicKey;

use Override;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Application\Service\Backend\PublicKey\BackendPublicKeyGetServiceInterface;

/**
 * @implements QueryHandlerInterface<BackendPublicKeyGetQuery,BackendPublicKeyGetQueryResult>
 */
final readonly class BackendPublicKeyGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private BackendPublicKeyGetServiceInterface $backendPublicKeyGetService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): BackendPublicKeyGetQueryResult
    {
        return new BackendPublicKeyGetQueryResult(
            public_key: $this->backendPublicKeyGetService->perform(),
        );
    }
}
