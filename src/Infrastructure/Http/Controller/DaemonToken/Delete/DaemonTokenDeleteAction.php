<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\DaemonToken\Delete;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Library\Enum\PhpType;
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
use Titanbot\Daemon\Application\UseCase\Command\DaemonToken\Delete\DaemonTokenDeleteCommand;
use Titanbot\Daemon\Application\UseCase\Command\DaemonToken\Delete\DaemonTokenDeleteCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\DaemonToken\Delete\DaemonTokenDeleteCommand as DaemonTokenDeleteCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\DaemonToken\Delete\DaemonTokenDeleteCommandResult as DaemonTokenDeleteCommandResultSchema;

#[AsController]
#[Route(Resource::DaemonTokenByUuid->value, name: Action::DaemonTokenDelete->value, methods: [Request::METHOD_DELETE])]
final class DaemonTokenDeleteAction
{
    public function __construct(

        /** @var CommandBusInterface<DaemonTokenDeleteCommand,DaemonTokenDeleteCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Delete(
        path: Resource::DaemonTokenByUuid->value,
        operationId: OpenApiOperationId::DaemonTokenDelete->value,
        summary: OpenApiSummary::DaemonTokenDelete->value,
        tags: [OpenApiTag::DaemonToken->value],
        parameters: [
            new OA\Parameter(
                name: 'uuid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: PhpType::string->value)
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_NO_CONTENT,
                description: OpenApiSchemaDescription::daemon_token->value,
            ),
        ],
    )]
    public function __invoke(DaemonTokenDeleteCommand $command): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_NO_CONTENT,
        );
    }
}
