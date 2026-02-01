<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\DaemonDb\Checksum;

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
use Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Checksum\DaemonDbChecksumGetQuery;
use Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Checksum\DaemonDbChecksumGetQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\DaemonDb\Checksum\DaemonDbChecksumGetQueryResult as DaemonDbChecksumGetQueryResultSchema;

#[AsController]
#[Route(Resource::DaemonDbChecksum->value, name: Action::DaemonDbChecksumGet->value, methods: [Request::METHOD_GET])]
final class DaemonDbChecksumGetAction
{
    public function __construct(

        /** @var QueryBusInterface<DaemonDbChecksumGetQuery,DaemonDbChecksumGetQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::DaemonDbChecksum->value,
        operationId: OpenApiOperationId::DaemonDbChecksumGet->value,
        summary: OpenApiSummary::DaemonDbChecksumGet->value,
        tags: [OpenApiTag::DaemonDb->value],
        parameters: [
            new OA\Parameter(
                name: 'logical_id',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: PhpType::int->value)
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::daemon_db->value,
                content: new OA\JsonContent(
                    ref: new Model(type: DaemonDbChecksumGetQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(DaemonDbChecksumGetQuery $query): Response
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
