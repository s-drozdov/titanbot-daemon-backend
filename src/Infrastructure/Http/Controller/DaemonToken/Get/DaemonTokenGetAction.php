<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\DaemonToken\Get;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
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
use Titanbot\Daemon\Application\Bus\Query\QueryBusInterface;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSchemaDescription;
use Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Get\DaemonTokenGetQuery;
use Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Get\DaemonTokenGetQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\DaemonToken\Get\DaemonTokenGetQueryResult as DaemonTokenGetQueryResultSchema;

#[AsController]
#[Route(Resource::DaemonTokenByUuid->value, name: Action::DaemonTokenGet->value, methods: [Request::METHOD_GET])]
final class DaemonTokenGetAction
{
    public function __construct(

        /** @var QueryBusInterface<DaemonTokenGetQuery,DaemonTokenGetQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::DaemonToken->value,
        operationId: OpenApiOperationId::DaemonTokenGet->value,
        summary: OpenApiSummary::DaemonTokenGet->value,
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
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::daemon_token->value,
                content: new OA\JsonContent(
                    ref: new Model(type: DaemonTokenGetQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(DaemonTokenGetQuery $query): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->queryBus->execute($query),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_OK,
        );
    }
}
