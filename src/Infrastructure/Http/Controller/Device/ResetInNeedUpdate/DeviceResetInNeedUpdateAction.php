<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Device\ResetInNeedUpdate;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Titanbot\Daemon\Infrastructure\Enum\Action;
use Titanbot\Daemon\Infrastructure\Enum\Resource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiTag;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSummary;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiOperationId;
use Titanbot\Daemon\Library\Enum\SerializationContextParam;
use Titanbot\Daemon\Application\Bus\Command\CommandBusInterface;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSchemaDescription;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Application\UseCase\Command\Device\ResetInNeedUpdate\DeviceResetInNeedUpdateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Device\ResetInNeedUpdate\DeviceResetInNeedUpdateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\ResetInNeedUpdate\DeviceResetInNeedUpdateCommand as DeviceResetInNeedUpdateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\ResetInNeedUpdate\DeviceResetInNeedUpdateCommandResult as DeviceResetInNeedUpdateCommandResultSchema;

#[AsController]
#[Route(Resource::DeviceInNeedUpdateReset->value, name: Action::DeviceInNeedUpdateResetPost->value, methods: [Request::METHOD_POST])]
final class DeviceResetInNeedUpdateAction
{
    public function __construct(

        /** @var CommandBusInterface<DeviceResetInNeedUpdateCommand,DeviceResetInNeedUpdateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::DeviceInNeedUpdateReset->value,
        operationId: OpenApiOperationId::DeviceInNeedUpdateReset->value,
        summary: OpenApiSummary::DeviceInNeedUpdateReset->value,
        tags: [OpenApiTag::Device->value, OpenApiTag::DaemonAccess->value],
        parameters: [
            new OA\Parameter(
                name: 'uuid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: OpenApiType::string->value),
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: OpenApiSchemaDescription::device->value,
            ),
        ],
    )]
    public function __invoke(DeviceResetInNeedUpdateCommand $command): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_ACCEPTED,
        );
    }
}
