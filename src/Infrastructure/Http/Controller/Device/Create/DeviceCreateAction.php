<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Device\Create;

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
use Titanbot\Daemon\Application\UseCase\Command\Device\Create\DeviceCreateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Device\Create\DeviceCreateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\Create\DeviceCreateCommand as DeviceCreateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Device\Create\DeviceCreateCommandResult as DeviceCreateCommandResultSchema;

#[AsController]
#[Route(Resource::Device->value, name: Action::DevicePost->value, methods: [Request::METHOD_POST])]
final class DeviceCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<DeviceCreateCommand,DeviceCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::Device->value,
        operationId: OpenApiOperationId::DeviceCreate->value,
        summary: OpenApiSummary::DeviceCreate->value,
        tags: [OpenApiTag::Device->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::device->value,
            content: new OA\JsonContent(
                ref: new Model(type: DeviceCreateCommandSchema::class)
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::device->value,
                content: new OA\JsonContent(
                    ref: new Model(type: DeviceCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(DeviceCreateCommand $command): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_CREATED,
        );
    }
}
