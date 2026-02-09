<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Legion\Index;

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
use Titanbot\Daemon\Application\Bus\Query\QueryBusInterface;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSchemaDescription;
use Titanbot\Daemon\Application\UseCase\Query\Legion\Index\LegionIndexQuery;
use Titanbot\Daemon\Application\UseCase\Query\Legion\Index\LegionIndexQueryResult;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Legion\Index\LegionIndexQueryResult as LegionIndexQueryResultSchema;

#[AsController]
#[Route(Resource::Legion->value, name: Action::LegionIndex->value, methods: [Request::METHOD_GET])]
final class LegionIndexAction
{
    public function __construct(

        /** @var QueryBusInterface<LegionIndexQuery,LegionIndexQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }
    
    #[OA\Get(
        path: Resource::Legion->value,
        operationId: OpenApiOperationId::LegionIndex->value,
        summary: OpenApiSummary::LegionIndex->value,
        tags: [OpenApiTag::Legion->value, OpenApiTag::AdminAccess->value],
        parameters: [
            new OA\Parameter(
                name: 'title',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: OpenApiType::string->value),
            ),
            new OA\Parameter(
                name: 'pay_day_of_month',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: OpenApiType::integer->value),
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::legion->value,
                content: new OA\JsonContent(
                    ref: new Model(type: LegionIndexQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(LegionIndexQuery $query): Response
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
