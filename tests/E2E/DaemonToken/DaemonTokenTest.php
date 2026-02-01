<?php

namespace Titanbot\Daemon\Tests\E2E\DaemonToken;

use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;
use Titanbot\Daemon\Domain\Entity\DaemonToken;

class DaemonTokenTest extends E2eTestCase
{
    #[Test]
    public function testLifeCycle(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(DaemonToken::class);

        /** CREATE */
        $data = [
            'token' => 'asdffgghhjk',
        ];

        $entity = $this->createToken($data);
        $this->assertSame('asdffgghhjk', $entity->getToken());

        /** READ */
        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/tokens/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertSame('asdffgghhjk', $data['daemon_token']['token']);

        /** READ by token */
        $this->getAdminClient()->jsonRequest('GET', '/daemon/tokens?token=asdffgghhjk');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['uuid_to_token_map']);
        $this->assertSame('asdffgghhjk', current($data['uuid_to_token_map'])['token']);
        $this->assertEquals((string) $entity->getUuid(), current($data['uuid_to_token_map'])['uuid']);

        /** INDEX */
        $this->getAdminClient()->jsonRequest('GET', '/daemon/tokens');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['uuid_to_token_map']);
        $this->assertTrue(
            array_any($data['uuid_to_token_map'], fn($value) => $value['token'] === 'asdffgghhjk'),
        );

        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', sprintf('/daemon/tokens/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);
        $this->assertNull($entity);
    }

    #[Test]
    public function testDeleteByTokenValue(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(DaemonToken::class);

        /** CREATE */
        $data = [
            'token' => 'asdffgghhjk',
        ];

        $entity = $this->createToken($data);

        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', '/daemon/tokens', ['token' => 'asdffgghhjk']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);
        $this->assertNull($entity);
    }

    #[Test]
    public function testEmptyRequests(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/tokens', []);
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());

        $this->getAdminClient()->jsonRequest('DELETE', '/daemon/tokens');
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());
    }
    
    #[Test]
    public function testDeleteNotExist(): void
    {
        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', '/daemon/tokens', ['token' => 'asdffgghhjk']);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    #[Test]
    public function testNotFoundStatus(): void
    {
        $uuid = $this->uuidHelper->create();

        $this->getAdminClient()->jsonRequest('GET', sprintf('/token/%s', (string) $uuid));
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    #[Test]
    public function testAccessAfterCreation(): void
    {
        $entity = $this->createToken(['token' => 'xxxxxxx1234565']);

        $this->assertNotNull($entity->getToken());
        $apiKey = $entity->getToken();

        $this->getAdminClient()->jsonRequest('POST', '/devices', ['physical_id' => 123456]);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $anonimousClient = $this->getAnonimousClient();

        $anonimousClient->jsonRequest('GET', '/devices?physical_id=123456');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $anonimousClient->setServerParameter(self::HEADER_X_API_KEY, $apiKey);

        $anonimousClient->jsonRequest('GET', '/devices?physical_id=123456');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getDaemonClient()->getResponse()->getContent(), true);

        $this->assertSame(123456, current($data['uuid_to_device_map'])['physical_id']);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $entity = $this->createToken(['token' => 'asdffgghhjk']);

        $this->getAnonimousClient()->jsonRequest('POST', '/daemon/tokens', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', sprintf('/daemon/tokens/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/tokens?token=asdffgghhjk');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/tokens');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('DELETE', sprintf('/daemon/tokens/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $entity = $this->createToken(['token' => 'asdffgghhjk']);

        $this->getHackerClient()->jsonRequest('POST', '/daemon/tokens', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', sprintf('/daemon/tokens/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/tokens?token=asdffgghhjk');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/tokens');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('DELETE', sprintf('/daemon/tokens/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessDaemon(): void
    {
        $entity = $this->createToken(['token' => 'asdffgghhjk']);

        $this->getDaemonClient()->jsonRequest('POST', '/daemon/tokens', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', sprintf('/daemon/tokens/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/tokens?token=asdffgghhjk');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/tokens');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('DELETE', sprintf('/daemon/tokens/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    private function createToken(array $data): DaemonToken
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(DaemonToken::class);

        $this->getAdminClient()->jsonRequest('POST', '/daemon/tokens', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotNull($data['uuid']);
        $uuid = $this->uuidHelper->fromString($data['uuid']);

        /** @var DaemonToken $entity */
        $entity = $repository->findOneBy(['uuid' => $uuid]);

        $this->assertNotNull($entity);

        return $entity;
    }
}
