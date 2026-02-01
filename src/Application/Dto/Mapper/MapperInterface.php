<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Application\Dto\Mapper;

use LogicException;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\DomainObjectInterface;

/**
 * @template TObject of DomainObjectInterface
 * @template TDto of DtoInterface
 */
interface MapperInterface
{
    /**
     * @param TObject $object
     * 
     * @return TDto
     * @throws LogicException
     */
    public function mapDomainObjectToDto(DomainObjectInterface $object): DtoInterface;

    /**
     * @param TDto $dto
     * 
     * @return TObject
     * @throws LogicException
     */
    public function mapDtoToDomainObject(DtoInterface $dto): DomainObjectInterface;

    /**
     * Getting inner type fqcn for serialization or null in case of simple types
     */
    public function getEntityType(): ?string;

    /**
     * Getting inner type fqcn for serialization or null in case of simple types
     */
    public function getDtoType(): ?string;
}
