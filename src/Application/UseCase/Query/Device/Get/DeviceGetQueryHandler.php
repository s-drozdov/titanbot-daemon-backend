<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Device\Get;

use InvalidArgumentException;
use Override;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Dto\Mapper\DeviceMapper;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Titanbot\Daemon\Domain\Service\Device\Get\DeviceGetServiceInterface;

/**
 * @implements QueryHandlerInterface<DeviceGetQuery,DeviceGetQueryResult>
 */
final readonly class DeviceGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private DeviceGetServiceInterface $deviceGetService,

        /** @var DeviceMapper $deviceMapper */
        private DeviceMapper $deviceMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): DeviceGetQueryResult
    {
        try {
            return new DeviceGetQueryResult(
                device: $this->deviceMapper->mapDomainObjectToDto(
                    $this->deviceGetService->perform($query->uuid),
                ),
            );
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
