<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\UseCase\Query\Ssh\GetByDevice;

use Override;
use InvalidArgumentException;
use Titanbot\Daemon\Application\Dto\Mapper\SshMapper;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Application\Bus\Query\QueryHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Titanbot\Daemon\Domain\Service\Ssh\GetByDevice\SshByDeviceGetServiceInterface;

/**
 * @implements QueryHandlerInterface<SshByDeviceGetQuery,SshByDeviceGetQueryResult>
 */
final readonly class SshByDeviceGetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SshByDeviceGetServiceInterface $sshByDeviceGetService,

        /** @var SshMapper $sshMapper */
        private SshMapper $sshMapper,
    ) {
        /*_*/
    }

    #[Override]
    public function __invoke(CqrsElementInterface $query): SshByDeviceGetQueryResult
    {
        try {
            return new SshByDeviceGetQueryResult(
                ssh: $this->sshMapper->mapDomainObjectToDto(
                    $this->sshByDeviceGetService->perform($query->device_uuid),
                ),
            );
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
