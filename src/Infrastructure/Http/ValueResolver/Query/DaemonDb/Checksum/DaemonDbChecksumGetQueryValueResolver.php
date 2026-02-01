<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Query\DaemonDb\Checksum;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Titanbot\Daemon\Application\UseCase\Query\DaemonDb\Checksum\DaemonDbChecksumGetQuery;

/**
 * @extends AbstractValueResolver<DaemonDbChecksumGetQuery>
 */
final readonly class DaemonDbChecksumGetQueryValueResolver extends AbstractValueResolver
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return DaemonDbChecksumGetQuery::class;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType [INFO]
     * @psalm-suppress LessSpecificReturnStatement [INFO]
     */
    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        return $this->denormalizer->denormalize(
            [
                'logical_id' => $request->query->get('logical_id') !== null ? (int) $request->query->get('logical_id') : null,
            ], 
            $this->getTargetClass(),
        );
    }
}