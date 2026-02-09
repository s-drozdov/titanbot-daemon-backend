<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\EmpireDate\Index;

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
use Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Index\EmpireDateIndexQuery;
use Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Index\EmpireDateIndexQueryResult;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\EmpireDate\Index\EmpireDateIndexQueryResult as EmpireDateIndexQueryResultSchema;

#[AsController]
#[Route(Resource::EmpireDate->value, name: Action::EmpireDateIndex->value, methods: [Request::METHOD_GET])]
final class EmpireDateIndexAction
{
    public function __construct(

        /** @var QueryBusInterface<EmpireDateIndexQuery,EmpireDateIndexQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::EmpireDate->value,
        operationId: OpenApiOperationId::EmpireDateIndex->value,
        summary: OpenApiSummary::EmpireDateIndex->value,
        tags: [OpenApiTag::EmpireDate->value, OpenApiTag::AdminAccess->value],
        parameters: [
            new OA\Parameter(
                name: 'date',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: OpenApiType::string->value),
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::empire_date->value,
                content: new OA\JsonContent(
                    ref: new Model(type: EmpireDateIndexQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(EmpireDateIndexQuery $query): Response
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
