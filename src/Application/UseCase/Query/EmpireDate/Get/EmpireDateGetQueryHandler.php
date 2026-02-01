<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Get;

use Override;
use InvalidArgumentException;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\EmpireDateMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Titanbot\Daemon\Domain\Service\EmpireDate\Get\EmpireDateGetServiceInterface;

/**
 * @implements QueryHandlerInterface<EmpireDateGetQuery,EmpireDateGetQueryResult>
 */
final readonly class EmpireDateGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmpireDateGetServiceInterface $empireDateGetService,

        /** @var EmpireDateMapper $empireDateMapper */
        private EmpireDateMapper $empireDateMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): EmpireDateGetQueryResult
    {
        try {
            return new EmpireDateGetQueryResult(
                empire_date: $this->empireDateMapper->mapDomainObjectToDto(
                    $this->empireDateGetService->perform($query->uuid),
                ),
            );
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
