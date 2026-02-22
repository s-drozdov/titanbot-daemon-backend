<?php

namespace Titanbot\Daemon\Tests\E2E\Habit;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;
use Titanbot\Daemon\Domain\Entity\Habit\Habit;
use Titanbot\Daemon\Domain\Entity\Habit\Pixel;

class HabitTest extends E2eTestCase
{
    #[Test]
    public function testLifeCycle(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Habit::class);

        /** CREATE */
        $data = [
            'priority' => 1000,
            'trigger_ocr' => null,
            'pixel_list' => [
                ['x' => 1, 'y' => 1, 'rgb_hex' => 'FF0099', 'deviation' => 12],
                ['x' => 2, 'y' => 2, 'rgb_hex' => '220099', 'deviation' => 4],
            ],
            'trigger_shell' => 'trigger_shell',
            'log_template' => 'log_template',
            'action' => 'action',
        ];

        $entity = $this->createHabit($data);
        
        $this->assertNotEmpty($entity->getPixelList()->toArray());
        $this->assertTrue(array_any($entity->getPixelList()->toArray(), fn (Pixel $pixel) => $pixel->getDot()->getX() === 2 && $pixel->getDot()->getY() === 2 && $pixel->getColor()->getRgbHex() === '220099' ));
        $this->assertSame(1000, $entity->getPriority());
        $this->assertNull($entity->getTriggerOcr());
        $this->assertSame('trigger_shell', $entity->getTriggerShell());
        $this->assertSame('log_template', $entity->getLogTemplate());

        /** READ */
        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/habits/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertSame('trigger_shell', $data['habit']['trigger_shell']);
        $this->assertSame(1000, $data['habit']['priority']);
        $this->assertNull($data['habit']['trigger_ocr']);

        /** INDEX */
        $this->getAdminClient()->jsonRequest('GET', '/daemon/habits');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['uuid_to_habit_map']);
        $this->assertNotEmpty(array_filter($data['uuid_to_habit_map'], fn (array $habit) => $habit['trigger_shell'] === 'trigger_shell'));

        /** UPDATE */
        $data = [
            'priority' => 1001,
            'action' => 'action2',
            'trigger_shell' => 'trigger_shell2',
        ];

        $this->getAdminClient()->jsonRequest('PATCH', sprintf('/daemon/habits/%s', (string) $entity->getUuid()), $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_ACCEPTED);

        $em = self::getContainer()->get('doctrine')->getManager();
        $entity = $em->getRepository(Habit::class)->find($entity->getUuid());

        $this->assertNotNull($entity);
        $this->assertSame(1001, $entity->getPriority());
        $this->assertNull($entity->getTriggerOcr());
        $this->assertSame('trigger_shell2', $entity->getTriggerShell());

        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', sprintf('/daemon/habits/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);
        $this->assertNull($entity);
    }

    #[Test]
    public function testEmptyRequests(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/habits', []);
        $this->assertTrue($this->getAdminClient()->getResponse()->isSuccessful());

        $this->getAdminClient()->jsonRequest('DELETE', '/daemon/habits');
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());
    }

    #[Test]
    public function testUpdatetAtChanges(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Habit::class);

        /** CREATE */
        $data = [
            'priority' => 1000,
            'trigger_ocr' => null,
            'pixel_list' => [],
            'trigger_shell' => null,
            'log_template' => null,
            'action' => 'action',
        ];

        $entity = $this->createHabit($data);
        $updatedAt = $entity->getUpdatedAt()->format(DateTimeImmutable::ATOM);

        usleep(1100000);
        $data = ['action' => 'action2'];

        $this->getAdminClient()->jsonRequest('PATCH', sprintf('/daemon/habits/%s', (string) $entity->getUuid()), $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_ACCEPTED);

        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);
        $this->assertNotEquals($updatedAt, $entity->getUpdatedAt()->format(DateTimeImmutable::ATOM));
    }

    #[Test]
    public function testNullableFieldsCreation(): void
    {
        $data = ['action' => 'action'];
        $entity = $this->createHabit($data);

        $this->assertNull($entity->getTriggerOcr());
        $this->assertNull($entity->getPriority());
    }

    #[Test]
    public function testNotFoundStatus(): void
    {
        $uuid = $this->uuidHelper->create();

        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/habits/%s', (string) $uuid));
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $entity = $this->createHabit(['action' => 'action']);

        $this->getAnonimousClient()->jsonRequest('POST', '/daemon/habits', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', sprintf('/daemon/habits/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/habits?slug=slug');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/habits');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        
        $this->getAnonimousClient()->jsonRequest('PATCH', sprintf('/daemon/habits/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('DELETE', sprintf('/daemon/habits/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $entity = $this->createHabit(['action' => 'action']);

        $this->getHackerClient()->jsonRequest('POST', '/daemon/habits', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', sprintf('/daemon/habits/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/habits');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        
        $this->getHackerClient()->jsonRequest('PATCH', sprintf('/daemon/habits/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('DELETE', sprintf('/daemon/habits/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessDaemon(): void
    {
        $entity = $this->createHabit(['action' => 'action']);

        $this->getDaemonClient()->jsonRequest('POST', '/daemon/habits', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', sprintf('/daemon/habits/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/habits');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        
        $this->getDaemonClient()->jsonRequest('PATCH', sprintf('/daemon/habits/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('DELETE', sprintf('/daemon/habits/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    private function createHabit(array $data): Habit
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Habit::class);

        $this->getAdminClient()->jsonRequest('POST', '/daemon/habits', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotNull($data['uuid']);
        $uuid = $this->uuidHelper->fromString($data['uuid']);

        /** @var Habit $entity */
        $entity = $repository->findOneBy(['uuid' => $uuid]);

        $this->assertNotNull($entity);
        $this->assertEquals($uuid, $entity->getUuid());

        return $entity;
    }
}
