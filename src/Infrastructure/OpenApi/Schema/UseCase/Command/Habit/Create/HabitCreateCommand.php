<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\OpenApi\Schema\UseCase\Command\Habit\Create;

use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;
use Titanbot\Daemon\Application\Dto\PixelRequestDto;
use Titanbot\Daemon\Infrastructure\Enum\OpenApiType;
use Titanbot\Daemon\Library\Collection\ListInterface;
use Titanbot\Daemon\Infrastructure\OpenApi\Schema\Dto\PixelRequestDto as PixelRequestDtoSchema;

/**
 * @psalm-suppress MissingConstructor [INFO]
 */
#[OA\Schema()]
final class HabitCreateCommand
{
    public string $action;

    /** 
     * @var ListInterface<PixelRequestDto>
     */
    #[OA\Property(
        type: OpenApiType::array->value,
        items: new OA\Items(ref: new Model(type: PixelRequestDtoSchema::class)),
    )]
    public ListInterface $pixel_list;
    
    public ?int $account_logical_id = null;
    
    public ?int $priority = null;
    
    public ?string $trigger_ocr = null;
    
    public ?string $trigger_shell = null;

    public ?string $log_template = null;
    
    public ?int $post_timeout_ms = null;

    public ?string $comment = null;

    public ?int $sequence = null;

    public bool $is_active = true;
}
