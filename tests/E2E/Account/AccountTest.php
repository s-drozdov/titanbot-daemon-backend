<?php

namespace Titanbot\Daemon\Tests\E2E\Account;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;
use Titanbot\Daemon\Domain\Entity\Device\Device;
use Titanbot\Daemon\Domain\Entity\Device\Account;

class AccountTest extends E2eTestCase
{
    #[Test]
    public function testLifeCycle(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Account::class);

        $device = $this->createDevice(['physical_id' => 123456]);

        /** CREATE */
        $data = [
            'logical_id' => 654321,
            'device_physical_id' => $device->getPhysicalId(),
            'first_name' => 'Test',
            'last_name' => 'Test2',
            'birth_date' => '2002-02-18T00:11:22',
            'gender' => 'male',
            'google_login' => 'test',
            'google_password' => '123456',
        ];

        $entity = $this->createAccount($data);

        $this->assertSame(654321, $entity->getLogicalId());
        $this->assertSame('Test', $entity->getFirstName());
        $this->assertSame('Test2', $entity->getLastName());
        $this->assertEquals(new DateTimeImmutable('2002-02-18'), $entity->getBirthDate());
        $this->assertSame('male', $entity->getGender()->value);
        $this->assertSame('test', $entity->getGoogleLogin());
        $this->assertSame('123456', $entity->getGooglePassword());

        /** READ */
        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertSame('123456', $data['account']['google_password']);
        $this->assertSame('male', $data['account']['gender']);

        /** READ by logical_id */
        $this->getDaemonClient()->jsonRequest('GET', '/daemon/accounts?logical_id=654321');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getDaemonClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['uuid_to_account_map']);
        $accountData = current($data['uuid_to_account_map']);

        $this->assertSame('123456', $accountData['google_password']);
        $this->assertSame('male', $accountData['gender']);
        $this->assertSame((string) $entity->getUuid(), $accountData['uuid']);

        /** INDEX */
        $this->getAdminClient()->jsonRequest('GET', '/daemon/accounts');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['uuid_to_account_map']);
        $accountData = current($data['uuid_to_account_map']);
        $this->assertSame(654321, $accountData['logical_id']);

        /** UPDATE */
        $data = [
            'first_name' => 'Test2',
            'last_name' => 'Test3',
            'birth_date' => '2002-02-18T00:11:44',
            'gender' => 'female',
            'google_login' => 'test2',
            'google_password' => '1234567',
        ];

        $this->getAdminClient()->jsonRequest('PATCH', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()), $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_ACCEPTED);

        $em = self::getContainer()->get('doctrine')->getManager();
        $entity = $em->getRepository(Account::class)->find($entity->getUuid());

        $this->assertSame(654321, $entity->getLogicalId());
        $this->assertSame('Test2', $entity->getFirstName());
        $this->assertSame('Test3', $entity->getLastName());
        $this->assertEquals(new DateTimeImmutable('2002-02-18T00:11:44'), $entity->getBirthDate());
        $this->assertSame('female', $entity->getGender()->value);
        $this->assertSame('test2', $entity->getGoogleLogin());
        $this->assertSame('1234567', $entity->getGooglePassword());

        $this->assertNotNull($entity);

        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);
        $this->assertNull($entity);
    }

    #[Test]
    public function testEmptyRequests(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/accounts', []);
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());

        $this->getAdminClient()->jsonRequest('DELETE', '/daemon/accounts');
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());
    }

    #[Test]
    public function testNotFoundStatus(): void
    {
        $uuid = $this->uuidHelper->create();

        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/accounts/%s', (string) $uuid));
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $device = $this->createDevice(['physical_id' => 123456]);

        /** CREATE */
        $data = [
            'logical_id' => 654321,
            'device_physical_id' => $device->getPhysicalId(),
            'first_name' => 'Test',
            'last_name' => 'Test2',
            'birth_date' => '2002-02-18T00:11:22',
            'gender' => 'male',
            'google_login' => 'test',
            'google_password' => '123456',
        ];

        $entity = $this->createAccount($data);

        $this->getAnonimousClient()->jsonRequest('POST', '/daemon/accounts', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/accounts?logical_id=654321');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/accounts');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        
        $this->getAnonimousClient()->jsonRequest('PATCH', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('DELETE', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $device = $this->createDevice(['physical_id' => 123456]);

        /** CREATE */
        $data = [
            'logical_id' => 654321,
            'device_physical_id' => $device->getPhysicalId(),
            'first_name' => 'Test',
            'last_name' => 'Test2',
            'birth_date' => '2002-02-18T00:11:22',
            'gender' => 'male',
            'google_login' => 'test',
            'google_password' => '123456',
        ];

        $entity = $this->createAccount($data);

        $this->getHackerClient()->jsonRequest('POST', '/daemon/accounts', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/accounts?logical_id=654321');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/accounts');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        
        $this->getHackerClient()->jsonRequest('PATCH', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('DELETE', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessDaemon(): void
    {
        $device = $this->createDevice(['physical_id' => 123456]);

        /** CREATE */
        $data = [
            'logical_id' => 654321,
            'device_physical_id' => $device->getPhysicalId(),
            'first_name' => 'Test',
            'last_name' => 'Test2',
            'birth_date' => '2002-02-18T00:11:22',
            'gender' => 'male',
            'google_login' => 'test',
            'google_password' => '123456',
        ];

        $entity = $this->createAccount($data);

        $this->getDaemonClient()->jsonRequest('POST', '/daemon/accounts', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/accounts?logical_id=654321');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/accounts');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $this->getDaemonClient()->jsonRequest('PATCH', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('DELETE', sprintf('/daemon/accounts/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    private function createAccount(array $data): Account
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Account::class);

        $this->getAdminClient()->jsonRequest('POST', '/daemon/accounts', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotNull($data['uuid']);
        $uuid = $this->uuidHelper->fromString($data['uuid']);

        /** @var Account $entity */
        $entity = $repository->findOneBy(['uuid' => $uuid]);
        $this->assertNotNull($entity);

        return $entity;
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
