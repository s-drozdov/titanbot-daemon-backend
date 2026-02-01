<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Habit\Update;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Library\Enum\PhpType;
use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Domain\ValueObject\UuidInterface;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\PixelRequestDto as PixelRequestDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class HabitUpdateCommand
{
    #[OA\Property(type: PhpType::string->value, nullable: false)]
    public UuidInterface $uuid;

    public ?string $action = null;

    /** 
     * @var ListInterface<PixelRequestDto>|null
     */
    #[OA\Property(
        type: PhpType::array->value,
        items: new OA\Items(ref: new Model(type: PixelRequestDtoSchema::class)),
    )]
    public ?ListInterface $pixel_list = null;

    public ?int $account_logical_id = null;

    public ?int $priority = null;

    public ?string $trigger_ocr = null;

    public ?string $trigger_shell = null;
    
    public ?bool $is_active = null;
}
