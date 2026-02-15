<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Command\Ssh\Create;

use Override;
use Webmozart\Assert\Assert;
use InvalidArgumentException;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Domain\Dto\Ssh\Create\SshCreateParamsDto;
use Titanbot\Daemon\Application\Bus\Command\CommandHandlerInterface;
use Titanbot\Daemon\Domain\Service\Ssh\Create\SshCreateServiceInterface;
use Titanbot\Daemon\Domain\Service\Device\Index\DeviceIndexServiceInterface;
use Titanbot\Daemon\Application\Service\Ssh\Generate\SshPairGenerateServiceInterface;

/**
 * @implements CommandHandlerInterface<SshCreateCommand,SshCreateCommandResult>
 */
final readonly class SshCreateCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SshPairGenerateServiceInterface $sshPairGenerateService,
        private SshCreateServiceInterface $sshCreateService,
        private DeviceIndexServiceInterface $deviceIndexService,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $command): SshCreateCommandResult
    {
        $sshPairDto = $this->sshPairGenerateService->perform($command->physical_id);

        $paramsDto = new SshCreateParamsDto(
            deviceUuid: $this->getDeviceUuid($command->physical_id),
            public: $sshPairDto->public,
            private: $sshPairDto->private,
            port: $command->port,
        );

        $entity = $this->sshCreateService->perform($paramsDto);

        return new SshCreateCommandResult(uuid: $entity->getUuid());
    }

    /**
     * @throws InvalidArgumentException
     */
    private function getDeviceUuid(int $physicalId): UuidInterface
    {
        $paginationResult = $this->deviceIndexService->perform($physicalId);
        $device = current($paginationResult->items->toArray());
        Assert::notFalse($device);

        /** @var Device $device */
        return $device->getUuid();
    }
}
