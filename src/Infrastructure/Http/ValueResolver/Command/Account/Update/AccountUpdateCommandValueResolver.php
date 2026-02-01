<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Command\Account\Update;

use Override;
use Webmozart\Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Titanbot\Daemon\Application\UseCase\Command\Account\Update\AccountUpdateCommand;

/**
 * @extends AbstractValueResolver<AccountUpdateCommand>
 */
final readonly class AccountUpdateCommandValueResolver extends AbstractValueResolver
{
    public function __construct(
        private DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
        private UuidHelperInterface $uuidHelper,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return AccountUpdateCommand::class;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType [INFO]
     * @psalm-suppress LessSpecificReturnStatement [INFO]
     */
    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        $uuid = $request->attributes->get('uuid');
        Assert::string($uuid);
        
        return $this->denormalizer->denormalize(
            [
                'uuid' => $this->uuidHelper->fromString($uuid),
                ...$request->toArray(),
            ], 
            $this->getTargetClass(),
        );
    }
}