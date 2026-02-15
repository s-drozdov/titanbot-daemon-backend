<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Ssh\GetByDevice;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Titanbot\Daemon\Infrastructure\Enum\Action;
use Titanbot\Daemon\Infrastructure\Enum\Resource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiTag;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSummary;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiOperationId;
use Titanbot\Daemon\Library\Enum\SerializationContextParam;
use Titanbot\Daemon\Application\Bus\Query\QueryBusInterface;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSchemaDescription;
use Titanbot\Daemon\Application\UseCase\Query\Ssh\GetByDevice\SshByDeviceGetQuery;
use Titanbot\Daemon\Application\UseCase\Query\Ssh\GetByDevice\SshByDeviceGetQueryResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Query\Ssh\GetByDevice\SshByDeviceGetQueryResult as SshByDeviceGetQueryResultSchema;

#[AsController]
#[Route(Resource::DeviceSsh->value, name: Action::SshByDeviceGet->value, methods: [Request::METHOD_GET])]
final class SshByDeviceGetAction
{
    public function __construct(

        /** @var QueryBusInterface<SshByDeviceGetQuery,SshByDeviceGetQueryResult> */
        private QueryBusInterface $queryBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::DeviceSsh->value,
        operationId: OpenApiOperationId::DeviceSshGet->value,
        summary: OpenApiSummary::DeviceSshGet->value,
        tags: [OpenApiTag::Ssh->value, OpenApiTag::AdminAccess->value, OpenApiTag::DaemonAccess->value],
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
                description: OpenApiSchemaDescription::ssh->value,
                content: new OA\JsonContent(
                    ref: new Model(type: SshByDeviceGetQueryResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(SshByDeviceGetQuery $query): Response
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
