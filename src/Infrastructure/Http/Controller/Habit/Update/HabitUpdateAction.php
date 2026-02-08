<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Habit\Update;

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
use Titanbot\Daemon\Application\UseCase\Command\Habit\Update\HabitUpdateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Habit\Update\HabitUpdateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Habit\Update\HabitUpdateCommand as HabitUpdateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Habit\Update\HabitUpdateCommandResult as HabitUpdateCommandResultSchema;

#[AsController]
#[Route(Resource::HabitByUuid->value, name: Action::HabitUpdate->value, methods: [Request::METHOD_PATCH])]
final class HabitUpdateAction
{
    public function __construct(

        /** @var CommandBusInterface<HabitUpdateCommand,HabitUpdateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Patch(
        path: Resource::HabitByUuid->value,
        operationId: OpenApiOperationId::HabitUpdate->value,
        summary: OpenApiSummary::HabitUpdate->value,
        tags: [OpenApiTag::Habit->value, OpenApiTag::AdminAccess->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::habit->value,
            content: new OA\JsonContent(
                ref: new Model(type: HabitUpdateCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: OpenApiSchemaDescription::habit->value,
                content: new OA\JsonContent(
                    ref: new Model(type: HabitUpdateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(HabitUpdateCommand $command): Response
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
