<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Command\EmpireDate\Create;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Titanbot\Daemon\Application\UseCase\Command\EmpireDate\Create\EmpireDateCreateCommand;

/**
 * @extends AbstractValueResolver<EmpireDateCreateCommand>
 */
final readonly class EmpireDateCreateCommandValueResolver extends AbstractValueResolver
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
        return EmpireDateCreateCommand::class;
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
                ...$request->toArray(),
            ], 
            $this->getTargetClass(),
        );
    }
}