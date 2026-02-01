<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Log\Create;

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
use Titanbot\Daemon\Application\UseCase\Command\Log\Create\LogCreateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Log\Create\LogCreateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Log\Create\LogCreateCommand as LogCreateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Log\Create\LogCreateCommandResult as LogCreateCommandResultSchema;

#[AsController]
#[Route(Resource::Log->value, name: Action::LogPost->value, methods: [Request::METHOD_POST])]
final class LogCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<LogCreateCommand,LogCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::Log->value,
        operationId: OpenApiOperationId::LogCreate->value,
        summary: OpenApiSummary::LogCreate->value,
        tags: [OpenApiTag::Log->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::log->value,
            content: new OA\JsonContent(
                ref: new Model(type: LogCreateCommandSchema::class)
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::log->value,
                content: new OA\JsonContent(
                    ref: new Model(type: LogCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(LogCreateCommand $command): Response
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
