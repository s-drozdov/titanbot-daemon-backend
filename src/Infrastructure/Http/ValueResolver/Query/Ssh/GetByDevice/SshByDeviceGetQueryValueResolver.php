<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Query\Ssh\GetByDevice;

use Override;
use Webmozart\Assert\Assert;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Titanbot\Daemon\Application\UseCase\Query\Ssh\GetByDevice\SshByDeviceGetQuery;

/**
 * @extends AbstractValueResolver<SshByDeviceGetQuery>
 */
final readonly class SshByDeviceGetQueryValueResolver extends AbstractValueResolver
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
        return SshByDeviceGetQuery::class;
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
                'device_uuid' => $this->uuidHelper->fromString($uuid),
            ], 
            $this->getTargetClass(),
        );
    }
}