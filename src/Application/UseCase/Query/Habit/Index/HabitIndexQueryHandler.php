<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Habit\Index;

use Override;
use Titanbot\Daemon\Library\Collection\Map;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\HabitMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\Habit\Index\HabitIndexServiceInterface;

/**
 * @implements QueryHandlerInterface<HabitIndexQuery,HabitIndexQueryResult>
 */
final readonly class HabitIndexQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private HabitIndexServiceInterface $habitIndexService,

        /** @var HabitMapper $habitMapper */
        private HabitMapper $habitMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): HabitIndexQueryResult
    {
        $paginationResult = $this->habitIndexService->perform(
            accountLogicalId: $query->account_logical_id,
            isActive: $query->is_active,
            action: $query->action,
        );

        $mapValue = array_reduce(
            $paginationResult->items->toArray(), 
            function (array $result, Habit $entity) {
                $result[(string) $entity->getUuid()] = $this->habitMapper->mapDomainObjectToDto($entity);

                return $result;
            }, 
            [],
        );

        return new HabitIndexQueryResult(
            uuid_to_habit_map: new Map(
                value: $mapValue,
                innerType: $this->habitMapper->getDtoType(),
            ),
        );
    }
}
