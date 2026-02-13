<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Log\BulkCreate;

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
use Titanbot\Daemon\Application\UseCase\Command\Log\CreateBulk\LogBulkCreateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Log\CreateBulk\LogBulkCreateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Log\CreateBulk\LogBulkCreateCommand as LogBulkCreateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Log\CreateBulk\LogBulkCreateCommandResult as LogBulkCreateCommandResultSchema;

#[AsController]
#[Route(Resource::LogBulk->value, name: Action::LogBulkPost->value, methods: [Request::METHOD_POST])]
final class LogBulkCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<LogBulkCreateCommand,LogBulkCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::LogBulk->value,
        operationId: OpenApiOperationId::LogBulkCreate->value,
        summary: OpenApiSummary::LogBulkCreate->value,
        tags: [OpenApiTag::Log->value, OpenApiTag::DaemonAccess->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::log->value,
            content: new OA\JsonContent(
                ref: new Model(type: LogBulkCreateCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::log->value,
                content: new OA\JsonContent(
                    ref: new Model(type: LogBulkCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(LogBulkCreateCommand $command): Response
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
