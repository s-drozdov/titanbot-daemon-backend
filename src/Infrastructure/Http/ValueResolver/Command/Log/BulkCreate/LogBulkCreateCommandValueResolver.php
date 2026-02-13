<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Http\ValueResolver\Command\Log\BulkCreate;

use Override;
use Webmozart\Assert\Assert;
use Titanbot\Daemon\Application\Dto\LogDto;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Application\Bus\CqrsElementInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Titanbot\Daemon\Infrastructure\Http\ValueResolver\AbstractValueResolver;
use Titanbot\Daemon\Application\UseCase\Command\Log\CreateBulk\LogBulkCreateCommand;

/**
 * @extends AbstractValueResolver<LogBulkCreateCommand>
 */
final readonly class LogBulkCreateCommandValueResolver extends AbstractValueResolver
{
    private const string LOG_DTO_LIST = 'log_dto_list';

    public function __construct(
        private DenormalizerInterface $denormalizer,
        ValidatorInterface $validator,
    ) {
        parent::__construct(validator: $validator);
    }

    #[Override]
    protected function getTargetClass(): string
    {
        return LogBulkCreateCommand::class;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType [INFO]
     * @psalm-suppress LessSpecificReturnStatement [INFO]
     */
    #[Override]
    protected function createFromRequest(Request $request): CqrsElementInterface
    {
        $logDtoList = $request->toArray()[self::LOG_DTO_LIST] ?? null;
        Assert::notNull($logDtoList);

        return $this->denormalizer->denormalize(
            [
                ...$request->toArray(),
                self::LOG_DTO_LIST => [
                    ListInterface::PROPERTY_VALUE => $logDtoList,
                    ListInterface::PROPERTY_INNER_TYPE => LogDto::class,
                ],
            ], 
            $this->getTargetClass(),
        );
    }
}
