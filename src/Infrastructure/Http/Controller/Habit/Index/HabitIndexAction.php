<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Habit\Index;

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
use Titanbot\Daemon\Application\UseCase\Query\Habit\Index\HabitIndexQuery;
use Titanbot\Daemon\Application\UseCase\Query\Habit\Index\HabitIndexQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Habit\Index\HabitIndexQueryResult as HabitIndexQueryResultSchema;

#[AsController]
#[Route(Resource::Habit->value, name: Action::HabitIndex->value, methods: [Request::METHOD_GET])]
final class HabitIndexAction
{
    public function __construct(

        /** @var QueryBusInterface<HabitIndexQuery,HabitIndexQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }
    
    #[OA\Get(
        path: Resource::Habit->value,
        operationId: OpenApiOperationId::HabitIndex->value,
        summary: OpenApiSummary::HabitIndex->value,
        tags: [OpenApiTag::Habit->value, OpenApiTag::AdminAccess->value],
        parameters: [
            new OA\Parameter(
                name: 'account_logical_id',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: PhpType::int->value),
            ),
            new OA\Parameter(
                name: 'is_active',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: PhpType::bool->value),
            ),
            new OA\Parameter(
                name: 'action',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: PhpType::string->value),
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::habit->value,
                content: new OA\JsonContent(
                    ref: new Model(type: HabitIndexQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(HabitIndexQuery $query): Response
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
