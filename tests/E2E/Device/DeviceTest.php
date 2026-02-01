<?php

namespace Titanbot\Daemon\Tests\E2E\Device;

use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;
use Titanbot\Daemon\Domain\Entity\Device\Device;

class DeviceTest extends E2eTestCase
{
    #[Test]
    public function testLifeCycle(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Device::class);

        /** CREATE */
        $data = [
            'physical_id' => 834221,
            'is_active' => false,
            'activity_type' => 'rowgplay',
            'is_empire_sleeping' => true,
            'is_full_server_detection' => false,
            'is_able_to_clear_cache' => false,
            'go_time_limit_seconds' => 220,
        ];

        $entity = $this->createDevice($data);

        $this->assertSame(834221, $entity->getPhysicalId());
        $this->assertSame('rowgplay', $entity->getActivityType()?->value);
        $this->assertSame(220, $entity->getGoTimeLimitSeconds());

        /** READ */
        $this->getAdminClient()->jsonRequest('GET', sprintf('/devices/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertSame(true, $data['device']['is_empire_sleeping']);
        $this->assertSame(834221, $data['device']['physical_id']);
        $this->assertSame(false, $data['device']['is_able_to_clear_cache']);
        $this->assertSame(false, $data['device']['is_active']);

        /** READ by physical_id */
        $this->getDaemonClient()->jsonRequest('GET', '/devices?physical_id=834221');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getDaemonClient()->getResponse()->getContent(), true);
        $device = current($data['uuid_to_device_map']);

        $this->assertSame(true, $device['is_empire_sleeping']);
        $this->assertSame((string) $entity->getUuid(), $device['uuid']);
        $this->assertSame(false, $device['is_able_to_clear_cache']);
        $this->assertSame(false, $device['is_active']);

        /** INDEX */
        $this->getAdminClient()->jsonRequest('GET', '/devices');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['uuid_to_device_map']);
        $this->assertSame(834221, current($data['uuid_to_device_map'])['physical_id']);

        /** UPDATE */
        $data = [
            'is_active' => true,
            'activity_type' => 'ajagplay',
            'is_empire_sleeping' => false,
            'is_full_server_detection' => true,
            'is_able_to_clear_cache' => true,
            'go_time_limit_seconds' => 100,
        ];

        $this->getAdminClient()->jsonRequest('PATCH', sprintf('/devices/%s', (string) $entity->getUuid()), $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_ACCEPTED);

        /** @var Device $entity */
        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);

        $this->assertNotNull($entity);
        $this->assertSame('ajagplay', $entity->getActivityType()?->value);
        $this->assertSame(true, $entity->isActive());
        $this->assertSame(false, $entity->isEmpireSleeping());
        $this->assertSame(true, $entity->isFullServerDetection());
        $this->assertSame(true, $entity->isAbleToClearCache());
        $this->assertSame(100, $entity->getGoTimeLimitSeconds());

        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', sprintf('/devices/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);
        $this->assertNull($entity);
    }

    #[Test]
    public function testEmptyRequests(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/devices', []);
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());

        $this->getAdminClient()->jsonRequest('DELETE', '/devices');
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());
    }

    #[Test]
    public function testNullableFieldsCreation(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Device::class);

        $data = [
            'physical_id' => 834221,
        ];

        $this->getAdminClient()->jsonRequest('POST', '/devices', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotNull($data['uuid']);
        $uuid = $this->uuidHelper->fromString($data['uuid']);

        /** @var Device $entity */
        $entity = $repository->findOneBy(['uuid' => $uuid]);

        $this->assertNotNull($entity);
        $this->assertSame(false, $entity->isActive());
        $this->assertSame('rowgplay', $entity->getActivityType()?->value);
        $this->assertSame(false, $entity->isEmpireSleeping());
        $this->assertSame(false, $entity->isFullServerDetection());
        $this->assertSame(false, $entity->isAbleToClearCache());
        $this->assertSame(100, $entity->getGoTimeLimitSeconds());
    }

    #[Test]
    public function testNotFoundStatus(): void
    {
        $uuid = $this->uuidHelper->create();

        $this->getAdminClient()->jsonRequest('GET', sprintf('/devices/%s', (string) $uuid));
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $entity = $this->createDevice(['physical_id' => 123456]);

        $this->getAnonimousClient()->jsonRequest('POST', '/devices', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', sprintf('/devices/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/devices?physical_id=834221');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        
        $this->getAnonimousClient()->jsonRequest('PATCH', sprintf('/devices/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('DELETE', sprintf('/devices/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $entity = $this->createDevice(['physical_id' => 123456]);

        $this->getHackerClient()->jsonRequest('POST', '/devices', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', sprintf('/devices/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/devices?physical_id=834221');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        
        $this->getHackerClient()->jsonRequest('PATCH', sprintf('/devices/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('DELETE', sprintf('/devices/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessDaemon(): void
    {
        $entity = $this->createDevice(['physical_id' => 123456]);

        $this->getDaemonClient()->jsonRequest('POST', '/devices', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', sprintf('/devices/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', '/devices?physical_id=123456');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->getDaemonClient()->jsonRequest('GET', '/devices');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $this->getDaemonClient()->jsonRequest('PATCH', sprintf('/devices/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('DELETE', sprintf('/devices/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    private function createDevice(array $data): Device
    {   
        $repository = self::getContainer()->get('doctrine')->getRepository(Device::class);

        $this->getAdminClient()->jsonRequest('POST', '/devices', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotNull($data['uuid']);
        $uuid = $this->uuidHelper->fromString($data['uuid']);

        /** @var Device $entity */
        $entity = $repository->findOneBy(['uuid' => $uuid]);

        $this->assertNotNull($entity);
        $this->assertEquals($uuid, $entity->getUuid());

        return $entity;
    }
}
