<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Device\Update;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
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
use Titanbot\Daemon\Application\UseCase\Command\Device\Update\DeviceUpdateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Device\Update\DeviceUpdateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\Update\DeviceUpdateCommand as DeviceUpdateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\Update\DeviceUpdateCommandResult as DeviceUpdateCommandResultSchema;

#[AsController]
#[Route(Resource::DeviceByUuid->value, name: Action::DeviceUpdate->value, methods: [Request::METHOD_PATCH])]
final class DeviceUpdateAction
{
    public function __construct(

        /** @var CommandBusInterface<DeviceUpdateCommand,DeviceUpdateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Patch(
        path: Resource::DeviceByUuid->value,
        operationId: OpenApiOperationId::DeviceUpdate->value,
        summary: OpenApiSummary::DeviceUpdate->value,
        tags: [OpenApiTag::Device->value, OpenApiTag::AdminAccess->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::device->value,
            content: new OA\JsonContent(
                ref: new Model(type: DeviceUpdateCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: OpenApiSchemaDescription::device->value,
                content: new OA\JsonContent(
                    ref: new Model(type: DeviceUpdateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(DeviceUpdateCommand $command): Response
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
