<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\Account\Create;

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
use Titanbot\Daemon\Application\UseCase\Command\Account\Create\AccountCreateCommand;
use Titanbot\Daemon\Application\UseCase\Command\Account\Create\AccountCreateCommandResult;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Account\Create\AccountCreateCommand as AccountCreateCommandSchema;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Account\Create\AccountCreateCommandResult as AccountCreateCommandResultSchema;

#[AsController]
#[Route(Resource::Account->value, name: Action::AccountPost->value, methods: [Request::METHOD_POST])]
final class AccountCreateAction
{
    public function __construct(

        /** @var CommandBusInterface<AccountCreateCommand,AccountCreateCommandResult> */
        private CommandBusInterface $commandBus,

        private SerializerInterface $serializer,
    ) {
        /*_*/
    }

    #[OA\Post(
        path: Resource::Account->value,
        operationId: OpenApiOperationId::AccountCreate->value,
        summary: OpenApiSummary::AccountCreate->value,
        tags: [OpenApiTag::Account->value, OpenApiTag::AdminAccess->value],
        requestBody: new OA\RequestBody(
            required: true,
            description: OpenApiSchemaDescription::account->value,
            content: new OA\JsonContent(
                ref: new Model(type: AccountCreateCommandSchema::class),
            ),
        ),
        responses: [
            new OA\Response(
                response: Response::HTTP_CREATED,
                description: OpenApiSchemaDescription::account->value,
                content: new OA\JsonContent(
                    ref: new Model(type: AccountCreateCommandResultSchema::class),
                ),
            ),
        ],
    )]
    public function __invoke(AccountCreateCommand $command): Response
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
