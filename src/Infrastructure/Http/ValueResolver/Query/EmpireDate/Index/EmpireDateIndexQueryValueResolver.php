<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Query\EmpireDate\Index;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Application\UseCase\Query\EmpireDate\Index\EmpireDateIndexQuery;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;

/**
 * @extends AbstractValueResolver<EmpireDateIndexQuery>
 */
final readonly class EmpireDateIndexQueryValueResolver extends AbstractValueResolver
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
        return EmpireDateIndexQuery::class;
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
                'date' => $request->query->get('date'),
            ], 
            $this->getTargetClass(),
        );
    }
}