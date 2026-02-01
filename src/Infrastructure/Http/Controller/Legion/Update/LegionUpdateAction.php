<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Legion\Update;

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
use Titanbot\Daemon\Application\UseCase\Command\Legion\Update\LegionUpdateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Legion\Update\LegionUpdateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Legion\Update\LegionUpdateCommand as LegionUpdateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Legion\Update\LegionUpdateCommandResult as LegionUpdateCommandResultSchema;

#[AsController]
#[Route(Resource::LegionByUuid->value, name: Action::LegionUpdate->value, methods: [Request::METHOD_PATCH])]
final class LegionUpdateAction
{
    public function __construct(

        /** @var CommandBusInterface<LegionUpdateCommand,LegionUpdateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Patch(
        path: Resource::LegionByUuid->value,
        operationId: OpenApiOperationId::LegionUpdate->value,
        summary: OpenApiSummary::LegionUpdate->value,
        tags: [OpenApiTag::Legion->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::legion->value,
            content: new OA\JsonContent(
                ref: new Model(type: LegionUpdateCommandSchema::class)
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: OpenApiSchemaDescription::legion->value,
                content: new OA\JsonContent(
                    ref: new Model(type: LegionUpdateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(LegionUpdateCommand $command): Response
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
