<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Habit\Get;

use InvalidArgumentException;
use Override;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\HabitMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\Habit\Get\HabitGetServiceInterface;

/**
 * @implements QueryHandlerInterface<HabitGetQuery,HabitGetQueryResult>
 */
final readonly class HabitGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HabitGetServiceInterface $habitGetService,

        /** @var HabitMapper $habitMapper */
        private HabitMapper $habitMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): HabitGetQueryResult
    {
        try {
            return new HabitGetQueryResult(
                habit: $this->habitMapper->mapDomainObjectToDto(
                    $this->habitGetService->perform($query->uuid),
                ),
            );
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
