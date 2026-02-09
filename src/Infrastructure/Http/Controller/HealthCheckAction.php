<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Titanbot\Daemon\Infrastructure\Enum\Action;
use Titanbot\Daemon\Infrastructure\Enum\Resource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiTag;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSummary;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiOperationId;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSchemaDescription;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;

#[AsController]
#[Route(Resource::HealthCheck->value, name: Action::HealthCheck->value, methods: [Request::METHOD_GET])]
final readonly class HealthCheckAction
{
    #[OA\Get(
        path: Resource::HealthCheck->value,
        operationId: OpenApiOperationId::HealthCheck->value,
        summary: OpenApiSummary::HealthCheck->value,
        tags: [OpenApiTag::Status->value, OpenApiTag::AdminAccess->value, OpenApiTag::DaemonAccess->value],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::status->value,
                content: new OA\JsonContent(
                    type: OpenApiType::object->value,
                    properties: [
                        new OA\Property(
                            property: 'status',
                            type: OpenApiType::string->value,
                            example: 'ok',
                        ),
                    ],
                ),
            ),
        ],
    )]
    public function __invoke(): Response
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
