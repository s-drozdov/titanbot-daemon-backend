<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Legion\Get;

use Override;
use InvalidArgumentException;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\LegionMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Titanbot\Daemon\Domain\Service\Legion\Get\LegionGetServiceInterface;

/**
 * @implements QueryHandlerInterface<LegionGetQuery,LegionGetQueryResult>
 */
final readonly class LegionGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LegionGetServiceInterface $legionGetService,

        /** @var LegionMapper $legionMapper */
        private LegionMapper $legionMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): LegionGetQueryResult
    {
        try {
            return new LegionGetQueryResult(
                legion: $this->legionMapper->mapDomainObjectToDto(
                    $this->legionGetService->perform($query->uuid),
                ),
            );
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
