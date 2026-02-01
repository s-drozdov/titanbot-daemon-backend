<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\DaemonToken\Create;

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
use Titanbot\Daemon\Application\UseCase\Command\DaemonToken\Create\DaemonTokenCreateCommand;
use Titanbot\Daemon\Application\UseCase\Command\DaemonToken\Create\DaemonTokenCreateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\DaemonToken\Create\DaemonTokenCreateCommand as DaemonTokenCreateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\DaemonToken\Create\DaemonTokenCreateCommandResult as DaemonTokenCreateCommandResultSchema;

#[AsController]
#[Route(Resource::DaemonToken->value, name: Action::DaemonTokenPost->value, methods: [Request::METHOD_POST])]
final class DaemonTokenCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<DaemonTokenCreateCommand,DaemonTokenCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::DaemonToken->value,
        operationId: OpenApiOperationId::DaemonTokenCreate->value,
        summary: OpenApiSummary::DaemonTokenCreate->value,
        tags: [OpenApiTag::DaemonToken->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::daemon_token->value,
            content: new OA\JsonContent(
                ref: new Model(type: DaemonTokenCreateCommandSchema::class)
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::daemon_token->value,
                content: new OA\JsonContent(
                    ref: new Model(type: DaemonTokenCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(DaemonTokenCreateCommand $command): Response
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
