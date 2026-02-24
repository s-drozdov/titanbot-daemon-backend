<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Domain\Factory\Ssh;

use Override;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Titanbot\Daemon\Domain\Dto\Ssh\Create\SshCreateParamsDto;
use Titanbot\Daemon\Domain\Repository\SshRepositoryInterface;

final readonly class SshFactory implements SshFactoryInterface
{
    public function __construct(
        private UuidHelperInterface $uuidHelper,
        private SshRepositoryInterface $SshRepository,
        private int $portRangeStart,
    ) {
        /*_*/
    }

    #[Override]
    public function create(SshCreateParamsDto $paramsDto): Ssh 
    {
        return new Ssh(
            uuid: $this->uuidHelper->create(),
            public: $paramsDto->public,
            private: $paramsDto->private,
            serverDeviceInternalPort: $paramsDto->serverDeviceInternalPort ?? $this->getFreePort(),
        );
    }

    private function getFreePort(): int
    {
        $portList = $this->SshRepository->findAllPorts()->toArray();
        $searchList = array_combine($portList, $portList);
        $port = $this->portRangeStart;

        while (true) {
            if (!isset($searchList[$port])) {
                return $port;
            }

            ++$port;
        }
    }
}
