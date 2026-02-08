<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Device\Index;

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
use Titanbot\Daemon\Application\UseCase\Query\Device\Index\DeviceIndexQuery;
use Titanbot\Daemon\Application\UseCase\Query\Device\Index\DeviceIndexQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Device\Index\DeviceIndexQueryResult as DeviceIndexQueryResultSchema;

#[AsController]
#[Route(Resource::Device->value, name: Action::DeviceIndex->value, methods: [Request::METHOD_GET])]
final class DeviceIndexAction
{
    public function __construct(

        /** @var QueryBusInterface<DeviceIndexQuery,DeviceIndexQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::Device->value,
        operationId: OpenApiOperationId::DeviceIndex->value,
        summary: OpenApiSummary::DeviceIndex->value,
        tags: [OpenApiTag::Device->value, OpenApiTag::AdminAccess->value, OpenApiTag::DaemonAccess->value],
        parameters: [
            new OA\Parameter(
                name: 'physical_id',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: PhpType::int->value),
            ),
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::device->value,
                content: new OA\JsonContent(
                    ref: new Model(type: DeviceIndexQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(DeviceIndexQuery $query): Response
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
