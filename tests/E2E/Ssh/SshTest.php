<?php

namespace Titanbot\Daemon\Tests\E2E\Ssh;

use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Entity\Device\Ssh;

class SshTest extends E2eTestCase
{
    #[Test]
    public function testLifeCycle(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Ssh::class);
        $device = $this->createDevice(['physical_id' => 123456]);

        /** READ */
        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/devices/%s/ssh', (string) $device->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['ssh']['private']);
        $this->assertNotEmpty($data['ssh']['public']);
        $this->assertNotEmpty($data['ssh']['server_device_internal_port']);
        $this->assertNotEmpty($data['ssh']['server_name']);
        $this->assertNotEmpty($data['ssh']['server_common_port']);

        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', sprintf('/daemon/devices/%s', (string) $device->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $entity = $repository->findOneBy(['serverDeviceInternalPort' => $data['ssh']['server_device_internal_port']]);
        $this->assertNull($entity);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $device = $this->createDevice(['physical_id' => 123456]);

        $this->getAnonimousClient()->jsonRequest('GET', sprintf('/daemon/devices/%s/ssh', (string) $device->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $device = $this->createDevice(['physical_id' => 123456]);

        $this->getHackerClient()->jsonRequest('GET', sprintf('/daemon/devices/%s/ssh', (string) $device->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessDaemon(): void
    {
        $device = $this->createDevice(['physical_id' => 123456]);

        $this->getDaemonClient()->jsonRequest('GET', sprintf('/daemon/devices/%s/ssh', (string) $device->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    private function createDevice(array $data): Device
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Device::class);

        $this->getAdminClient()->jsonRequest('POST', '/daemon/devices', $data);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $uuid = $this->uuidHelper->fromString($data['uuid']);

        /** @var Device $entity */
        $entity = $repository->findOneBy(['uuid' => $uuid]);
        $this->assertNotNull($entity);

        return $entity;
    }
}
