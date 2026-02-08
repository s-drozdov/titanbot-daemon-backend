<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Habit\Create;

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
use Titanbot\Daemon\Application\UseCase\Command\Habit\Create\HabitCreateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Habit\Create\HabitCreateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Habit\Create\HabitCreateCommand as HabitCreateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Habit\Create\HabitCreateCommandResult as HabitCreateCommandResultSchema;

#[AsController]
#[Route(Resource::Habit->value, name: Action::HabitPost->value, methods: [Request::METHOD_POST])]
final class HabitCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<HabitCreateCommand,HabitCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::Habit->value,
        operationId: OpenApiOperationId::HabitCreate->value,
        summary: OpenApiSummary::HabitCreate->value,
        tags: [OpenApiTag::Habit->value, OpenApiTag::AdminAccess->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::habit->value,
            content: new OA\JsonContent(
                ref: new Model(type: HabitCreateCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::habit->value,
                content: new OA\JsonContent(
                    ref: new Model(type: HabitCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(HabitCreateCommand $command): Response
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
