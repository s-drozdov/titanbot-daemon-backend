<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\EmpireDate\Get;

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
use Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Get\EmpireDateGetQuery;
use Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Get\EmpireDateGetQueryResult;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\EmpireDate\Get\EmpireDateGetQueryResult as EmpireDateGetQueryResultSchema;

#[AsController]
#[Route(Resource::EmpireDateByUuid->value, name: Action::EmpireDateGet->value, methods: [Request::METHOD_GET])]
final class EmpireDateGetAction
{
    public function __construct(

        /** @var QueryBusInterface<EmpireDateGetQuery,EmpireDateGetQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::EmpireDateByUuid->value,
        operationId: OpenApiOperationId::EmpireDateGet->value,
        summary: OpenApiSummary::EmpireDateGet->value,
        tags: [OpenApiTag::EmpireDate->value, OpenApiTag::AdminAccess->value],
        parameters: [
            new OA\Parameter(
                name: 'uuid',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: OpenApiType::string->value),
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::empire_date->value,
                content: new OA\JsonContent(
                    ref: new Model(type: EmpireDateGetQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(EmpireDateGetQuery $query): Response
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
