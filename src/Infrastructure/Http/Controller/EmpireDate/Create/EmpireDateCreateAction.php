<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\EmpireDate\Create;

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
use Titanbot\Daemon\Application\Bus\Command\CommandBusInterface;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSchemaDescription;
use Titanbot\Daemon\Application\UseCase\Command\EmpireDate\Create\EmpireDateCreateCommand;
use Titanbot\Daemon\Application\UseCase\Command\EmpireDate\Create\EmpireDateCreateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\EmpireDate\Create\EmpireDateCreateCommand as EmpireDateCreateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\EmpireDate\Create\EmpireDateCreateCommandResult as EmpireDateCreateCommandResultSchema;

#[AsController]
#[Route(Resource::EmpireDate->value, name: Action::EmpireDatePost->value, methods: [Request::METHOD_POST])]
final class EmpireDateCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<EmpireDateCreateCommand,EmpireDateCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::EmpireDate->value,
        operationId: OpenApiOperationId::EmpireDateCreate->value,
        summary: OpenApiSummary::EmpireDateCreate->value,
        tags: [OpenApiTag::EmpireDate->value, OpenApiTag::AdminAccess->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::empire_date->value,
            content: new OA\JsonContent(
                ref: new Model(type: EmpireDateCreateCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::empire_date->value,
                content: new OA\JsonContent(
                    ref: new Model(type: EmpireDateCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(EmpireDateCreateCommand $command): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_CREATED,
        );
    }
}
