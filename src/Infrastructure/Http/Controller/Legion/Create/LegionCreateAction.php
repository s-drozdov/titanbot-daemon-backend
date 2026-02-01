<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Legion\Create;

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
use Titanbot\Daemon\Application\UseCase\Command\Legion\Create\LegionCreateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Legion\Create\LegionCreateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Legion\Create\LegionCreateCommand as LegionCreateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Legion\Create\LegionCreateCommandResult as LegionCreateCommandResultSchema;

#[AsController]
#[Route(Resource::Legion->value, name: Action::LegionPost->value, methods: [Request::METHOD_POST])]
final class LegionCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<LegionCreateCommand,LegionCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::Legion->value,
        operationId: OpenApiOperationId::LegionCreate->value,
        summary: OpenApiSummary::LegionCreate->value,
        tags: [OpenApiTag::Legion->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::legion->value,
            content: new OA\JsonContent(
                ref: new Model(type: LegionCreateCommandSchema::class)
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::legion->value,
                content: new OA\JsonContent(
                    ref: new Model(type: LegionCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(LegionCreateCommand $command): Response
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
