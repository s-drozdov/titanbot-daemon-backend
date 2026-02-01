<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Account\Index;

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
use Titanbot\Daemon\Application\UseCase\Query\Account\Index\AccountIndexQuery;
use Titanbot\Daemon\Application\UseCase\Query\Account\Index\AccountIndexQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Account\Index\AccountIndexQueryResult as AccountIndexQueryResultSchema;

#[AsController]
#[Route(Resource::Account->value, name: Action::AccountIndex->value, methods: [Request::METHOD_GET])]
final class AccountIndexAction
{
    public function __construct(

        /** @var QueryBusInterface<AccountIndexQuery,AccountIndexQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::Account->value,
        operationId: OpenApiOperationId::AccountIndex->value,
        summary: OpenApiSummary::AccountIndex->value,
        tags: [OpenApiTag::Account->value],
        parameters: [
            new OA\Parameter(
                name: 'logical_id',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: PhpType::int->value)
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::account->value,
                content: new OA\JsonContent(
                    ref: new Model(type: AccountIndexQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(AccountIndexQuery $query): Response
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
