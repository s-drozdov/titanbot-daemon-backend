<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Query\Habit\Index;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Application\UseCase\Query\Habit\Index\HabitIndexQuery;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;

/**
 * @extends AbstractValueResolver<HabitIndexQuery>
 */
final readonly class HabitIndexQueryValueResolver extends AbstractValueResolver
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
        return HabitIndexQuery::class;
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
                'account_logical_id' => $request->query->get('account_logical_id') !== null ? (int) $request->query->get('account_logical_id') : null,
                'is_active' => $request->query->get('is_active') !== null ? (bool) $request->query->get('is_active') : null,
                'action' => $request->query->get('action'),
            ], 
            $this->getTargetClass(),
        );
    }
}