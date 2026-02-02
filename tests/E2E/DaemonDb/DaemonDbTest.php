<?php

namespace Titanbot\Daemon\Tests\E2E\DaemonDb;

use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;

class DaemonDbTest extends E2eTestCase
{
    private const array DEVICE_DATA = ['physical_id' => 834221];
    private const array DEVICE_DATA2 = ['physical_id' => 834222];

    private const array ACCOUNT_DATA = [
        'logical_id' => 44646,
        'device_physical_id' => 834221,
        'first_name' => 'Test',
        'last_name' => 'Test2',
        'birth_date' => '2002-02-18T00:11:22',
        'gender' => 'male',
        'google_login' => 'test',
        'google_password' => '123456',
    ];

    private const array ACCOUNT_DATA2 = [
        'logical_id' => 44647,
        'device_physical_id' => 834222,
        'first_name' => 'Test2',
        'last_name' => 'Test3',
        'birth_date' => '2002-02-18T00:11:22',
        'gender' => 'male',
        'google_login' => 'test2',
        'google_password' => '123456',
    ];

    #[Test]
    public function testChecksum(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/devices', self::DEVICE_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->getAdminClient()->jsonRequest('POST', '/daemon/accounts', self::ACCOUNT_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $this->getChecksum(44646);
    }
    
    #[Test]
    public function testDownload(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/devices', self::DEVICE_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->getAdminClient()->jsonRequest('POST', '/daemon/accounts', self::ACCOUNT_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/db?logical_id=44646');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->assertResponseHeaderSame('Content-Type', 'application/vnd.sqlite3');
        $this->assertStringContainsString('attachment; filename=', $this->getDaemonClient()->getResponse()->headers->get('Content-Disposition'));
    }

    #[Test]
    public function testChecksumChanging(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/devices', self::DEVICE_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->getAdminClient()->jsonRequest('POST', '/daemon/accounts', self::ACCOUNT_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->getAdminClient()->jsonRequest('POST', '/daemon/devices', self::DEVICE_DATA2);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->getAdminClient()->jsonRequest('POST', '/daemon/accounts', self::ACCOUNT_DATA2);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $checksum1 = $this->getChecksum(44646);
        $this->assertSame($checksum1, $this->getChecksum(44646));

        $this->createHabit(['account_logical_id' => 44647, 'slug' => 's', 'action' => 'a']);
        $this->assertSame($checksum1, $this->getChecksum(44646));

        $this->createHabit(['account_logical_id' => 44646, 'slug' => 's2', 'action' => 'a2']);
        $checksum2 = $this->getChecksum(44646);
        $this->assertNotEquals($checksum1, $checksum2);
        $this->assertSame($checksum2, $this->getChecksum(44646));
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/devices', self::DEVICE_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->getAdminClient()->jsonRequest('POST', '/daemon/accounts', self::ACCOUNT_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/db/checksum?logical_id=44646');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/db?logical_id=44646');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/devices', self::DEVICE_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->getAdminClient()->jsonRequest('POST', '/daemon/accounts', self::ACCOUNT_DATA);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/db/checksum?logical_id=44646');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/db?logical_id=44646');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    private function getChecksum(int $logicalId): string
    {
        $this->getDaemonClient()->jsonRequest('GET', sprintf('/daemon/db/checksum?logical_id=%d', $logicalId));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getDaemonClient()->getResponse()->getContent(), true);
        
        $this->assertNotEmpty($data['checksum']);
        $this->assertIsString($data['checksum']);

        return $data['checksum'];
    }

    private function createHabit(array $data): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/habits', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }
}
