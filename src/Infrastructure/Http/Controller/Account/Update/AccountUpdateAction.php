<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Account\Update;

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
use Titanbot\Daemon\Application\UseCase\Command\Account\Update\AccountUpdateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Account\Update\AccountUpdateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Account\Update\AccountUpdateCommand as AccountUpdateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Account\Update\AccountUpdateCommandResult as AccountUpdateCommandResultSchema;

#[AsController]
#[Route(Resource::AccountByUuid->value, name: Action::AccountUpdate->value, methods: [Request::METHOD_PATCH])]
final class AccountUpdateAction
{
    public function __construct(

        /** @var CommandBusInterface<AccountUpdateCommand,AccountUpdateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Patch(
        path: Resource::AccountByUuid->value,
        operationId: OpenApiOperationId::AccountUpdate->value,
        summary: OpenApiSummary::AccountUpdate->value,
        tags: [OpenApiTag::Account->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::account->value,
            content: new OA\JsonContent(
                ref: new Model(type: AccountUpdateCommandSchema::class)
            )
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_ACCEPTED,
                description: OpenApiSchemaDescription::account->value,
                content: new OA\JsonContent(
                    ref: new Model(type: AccountUpdateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(AccountUpdateCommand $command): Response
    {
        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $this->commandBus->execute($command),
                JsonEncoder::FORMAT,
                [SerializationContextParam::isHttpResponse->value => true],
            ),
            Response::HTTP_ACCEPTED,
        );
    }
}
