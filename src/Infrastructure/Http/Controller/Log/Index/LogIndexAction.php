<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Log\Index;

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
use Titanbot\Daemon\Application\UseCase\Query\Log\Index\LogIndexQuery;
use Titanbot\Daemon\Application\UseCase\Query\Log\Index\LogIndexQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Log\Index\LogIndexQueryResult as LogIndexQueryResultSchema;

#[AsController]
#[Route(Resource::Log->value, name: Action::LogIndex->value, methods: [Request::METHOD_GET])]
final class LogIndexAction
{
    public function __construct(

        /** @var QueryBusInterface<LogIndexQuery,LogIndexQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }
    
    #[OA\Get(
        path: Resource::Log->value,
        operationId: OpenApiOperationId::LogIndex->value,
        summary: OpenApiSummary::LogIndex->value,
        tags: [OpenApiTag::Log->value, OpenApiTag::AdminAccess->value],
        parameters: [
            new OA\Parameter(
                name: 'message',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: PhpType::string->value),
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::log->value,
                content: new OA\JsonContent(
                    ref: new Model(type: LogIndexQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(LogIndexQuery $query): Response
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
