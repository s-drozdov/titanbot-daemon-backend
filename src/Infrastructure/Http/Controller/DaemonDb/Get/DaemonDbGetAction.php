<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\Controller\DaemonDb\Get;

use OpenApi\Attributes as OA;
use Titanbot\Daemon\Library\Enum\PhpType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Titanbot\Daemon\Infrastructure\Enum\Action;
use Titanbot\Daemon\Infrastructure\Enum\Resource;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiTag;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSummary;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiOperationId;
use Titanbot\Daemon\Application\Bus\Query\QueryBusInterface;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiSchemaDescription;
use Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Get\DaemonDbGetQuery;
use Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Get\DaemonDbGetQueryResult;

#[AsController]
#[Route(Resource::DaemonDb->value, name: Action::DaemonDbGet->value, methods: [Request::METHOD_GET])]
final class DaemonDbGetAction
{
    public function __construct(

        /** @var QueryBusInterface<DaemonDbGetQuery,DaemonDbGetQueryResult> */
        private QueryBusInterface $queryBus,

        private string $dbExportFilename,
    ) {
        /*_*/
    }

    #[OA\Get(
        path: Resource::DaemonDb->value,
        operationId: OpenApiOperationId::DaemonDbGet->value,
        summary: OpenApiSummary::DaemonDbGet->value,
        tags: [OpenApiTag::DaemonDb->value],
        parameters: [
            new OA\Parameter(
                name: 'logical_id',
                in: 'query',
                required: true,
                schema: new OA\Schema(type: PhpType::int->value)
            )
        ],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: OpenApiSchemaDescription::daemon_db->value,
                content: new OA\MediaType(
                    mediaType: 'application/vnd.sqlite3',
                    schema: new OA\Schema(
                        type: PhpType::int->value,
                        format: 'binary',
                    ),
                ),
            ),
        ],
    )]
    public function __invoke(DaemonDbGetQuery $query): Response
    {
        /** @var DaemonDbGetQueryResult $result */
        $result = $this->queryBus->execute($query);

        return new BinaryFileResponse($result->temp_file)
            ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $this->dbExportFilename)
            ->deleteFileAfterSend(true)
        ;
    }
}
