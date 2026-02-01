<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Converter;

use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;

/**
 * @template TEntity of EntityInterface
 * @template TDto of DtoInterface
 */
final readonly class PaginationResultToDtoConverter
{
    /**
     * @param PaginationResult<TEntity> $paginationResult
     * @param MapperInterface<TEntity, TDto> $mapper
     * 
     * @return PaginationResult<TDto>
     */
    public function convert(
        PaginationResult $paginationResult, 
        MapperInterface $mapper,
    ): PaginationResult {
        return new PaginationResult(
            items: new Collection(
                array_map(

                    /** 
                     * @param TEntity $entity 
                     * 
                     * @return TDto
                     */
                    fn (EntityInterface $entity) => $mapper->mapDomainObjectToDto($entity), 
                    
                    $paginationResult->items->toArray(),
                ),
                $mapper->getDtoType(),
            ),
            total: $paginationResult->total,
        );
    }
}
