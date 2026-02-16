<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Backend\PublicKey;

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
use Titanbot\Daemon\Application\UseCase\Query\Backend\PublicKey\BackendPublicKeyGetQuery;
use Titanbot\Daemon\Application\UseCase\Query\Backend\PublicKey\BackendPublicKeyGetQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Backend\PublicKey\BackendPublicKeyGetQueryResult as BackendPublicKeyGetQueryResultSchema;

#[AsController]
#[Route(Resource::BackendPublicKey->value, name: Action::BackendPublicKeyGet->value, methods: [Request::METHOD_GET])]
final class BackendPublicKeyGetAction
{
    public function __construct(

        /** @var QueryBusInterface<BackendPublicKeyGetQuery,BackendPublicKeyGetQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::BackendPublicKey->value,
        operationId: OpenApiOperationId::BackendPublicKeyGet->value,
        summary: OpenApiSummary::BackendPublicKeyGet->value,
        tags: [OpenApiTag::Backend->value, OpenApiTag::AdminAccess->value, OpenApiTag::DaemonAccess->value],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::backend_public_key->value,
                content: new OA\JsonContent(
                    ref: new Model(type: BackendPublicKeyGetQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(BackendPublicKeyGetQuery $query): Response
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
