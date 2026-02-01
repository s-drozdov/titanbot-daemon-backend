<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\EmpireDate\GetNext;

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
use Titanbot\Daemon\Application\UseCase\Query\EmpireDate\GetNext\EmpireDateNextGetQuery;
use Titanbot\Daemon\Application\UseCase\Query\EmpireDate\GetNext\EmpireDateNextGetQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\EmpireDate\GetNext\EmpireDateNextGetQueryResult as EmpireDateNextGetQueryResultSchema;

#[AsController]
#[Route(Resource::EmpireDateNext->value, name: Action::EmpireDateNextGet->value, methods: [Request::METHOD_GET])]
final class EmpireDateNextGetAction
{
    public function __construct(

        /** @var QueryBusInterface<EmpireDateNextGetQuery,EmpireDateNextGetQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::EmpireDateNext->value,
        operationId: OpenApiOperationId::EmpireDateNextGet->value,
        summary: OpenApiSummary::EmpireDateNextGet->value,
        tags: [OpenApiTag::EmpireDate->value],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::empire_date->value,
                content: new OA\JsonContent(
                    ref: new Model(type: EmpireDateNextGetQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(EmpireDateNextGetQuery $query): Response
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
