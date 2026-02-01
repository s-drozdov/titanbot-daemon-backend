<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Device\Index;

use Override;
use Titanbot\Daemon\Library\Collection\Map;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\DeviceMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\Device\Index\DeviceIndexServiceInterface;

/**
 * @implements QueryHandlerInterface<DeviceIndexQuery,DeviceIndexQueryResult>
 */
final readonly class DeviceIndexQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DeviceIndexServiceInterface $deviceIndexService,

        /** @var DeviceMapper $deviceMapper */
        private DeviceMapper $deviceMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): DeviceIndexQueryResult
    {
        $paginationResult = $this->deviceIndexService->perform($query->physical_id);

        $mapValue = array_reduce(
            $paginationResult->items->toArray(), 
            function (array $result, Device $entity) {
                $result[(string) $entity->getUuid()] = $this->deviceMapper->mapDomainObjectToDto($entity);

                return $result;
            }, 
            [],
        );

        return new DeviceIndexQueryResult(
            uuid_to_device_map: new Map(
                value: $mapValue,
                innerType: $this->deviceMapper->getDtoType(),
            ),
        );
    }
}
