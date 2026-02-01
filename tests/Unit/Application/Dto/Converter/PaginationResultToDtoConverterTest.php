<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Tests\Unit\Application\Dto\Converter;

use LogicException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Application\Dto\DtoInterface;
use Titanbot\Daemon\Domain\Entity\EntityInterface;
use Titanbot\Daemon\Library\Collection\Collection;
use Titanbot\Daemon\Application\Dto\Mapper\MapperInterface;
use Titanbot\Daemon\Domain\Repository\Filter\PaginationResult;
use Titanbot\Daemon\Application\Dto\Converter\PaginationResultToDtoConverter;

final class PaginationResultToDtoConverterTest extends TestCase
{
    private const int TOTAL = 42;

    #[Test]
    public function testConvertMapsEntitiesToDtosAndKeepsTotal(): void
    {
        // arrange
        $entity1 = $this->createStub(EntityInterface::class);
        $entity2 = $this->createStub(EntityInterface::class);

        $dto1 = $this->createStub(DtoInterface::class);
        $dto2 = $this->createStub(DtoInterface::class);

        $paginationResult = new PaginationResult(
            items: new Collection([$entity1, $entity2], EntityInterface::class),
            total: self::TOTAL,
        );

        $mapper = $this->createMock(MapperInterface::class);

        $mapper
            ->expects(self::exactly(2))
            ->method('mapDomainObjectToDto')
            ->willReturnCallback(
                static function (EntityInterface $entity) use ($entity1, $entity2, $dto1, $dto2) {
                    return match ($entity) {
                        $entity1 => $dto1,
                        $entity2 => $dto2,
                        default => throw new LogicException('Unexpected entity'),
                    };
                },
            )
        ;

        $mapper->expects(self::once())->method('getDtoType')->willReturn(DtoInterface::class);

        $converter = new PaginationResultToDtoConverter();

        // act
        $result = $converter->convert($paginationResult, $mapper);

        // assert
        self::assertSame(self::TOTAL, $result->total);
        self::assertCount(2, $result->items);
        self::assertSame([$dto1, $dto2], $result->items->toArray());
    }
}
