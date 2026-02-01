<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\DaemonToken\DeleteByValue;

use InvalidArgumentException;
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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSchemaDescription;
use Titanbot\Daemon\Application\UseCase\Command\DaemonToken\DeleteByValue\DaemonTokenByValueDeleteCommand;
use Titanbot\Daemon\Application\UseCase\Command\DaemonToken\DeleteByValue\DaemonTokenByValueDeleteCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\DaemonToken\DeleteByValue\DaemonTokenByValueDeleteCommand as DaemonTokenByValueDeleteCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\DaemonToken\DeleteByValue\DaemonTokenByValueDeleteCommandResult as DaemonTokenByValueDeleteCommandResultSchema;

#[AsController]
#[Route(Resource::DaemonToken->value, name: Action::DaemonTokenDeleteByValue->value, methods: [Request::METHOD_DELETE])]
final class DaemonTokenByValueDeleteAction
{
    public function __construct(

        /** @var CommandBusInterface<DaemonTokenByValueDeleteCommand,DaemonTokenByValueDeleteCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Delete(
        path: Resource::DaemonToken->value,
        operationId: OpenApiOperationId::DaemonTokenDeleteByValue->value,
        summary: OpenApiSummary::DaemonTokenDeleteByValue->value,
        tags: [OpenApiTag::DaemonToken->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::daemon_token->value,
            content: new OA\JsonContent(
                ref: new Model(type: DaemonTokenByValueDeleteCommandSchema::class)
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_NO_CONTENT,
                description: OpenApiSchemaDescription::account->value,
            ),
        ],
    )]
    public function __invoke(DaemonTokenByValueDeleteCommand $command): Response
    {
        try {
            return JsonResponse::fromJsonString(
                $this->serializer->serialize(
                    $this->commandBus->execute($command),
                    JsonEncoder::FORMAT,
                    [SerializationContextParam::isHttpResponse->value => true],
                ),
                Response::HTTP_NO_CONTENT,
            );
        } catch (InvalidArgumentException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
