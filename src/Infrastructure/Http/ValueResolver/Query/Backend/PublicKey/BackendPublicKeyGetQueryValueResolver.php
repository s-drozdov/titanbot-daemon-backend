<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Query\Backend\PublicKey;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Titanbot\Daemon\Application\UseCase\Query\Backend\PublicKey\BackendPublicKeyGetQuery;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;

/**
 * @extends AbstractValueResolver<BackendPublicKeyGetQuery>
 */
final readonly class BackendPublicKeyGetQueryValueResolver extends AbstractValueResolver
{
    public function __construct(
        ValidatorInterface $validator,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return BackendPublicKeyGetQuery::class;
    }

    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        return new BackendPublicKeyGetQuery();
    }
}
