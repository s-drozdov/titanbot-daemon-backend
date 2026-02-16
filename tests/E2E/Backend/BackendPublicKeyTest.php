<?php

namespace Titanbot\Daemon\Tests\E2E\Backend;

use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;

class BackendPublicKeyTest extends E2eTestCase
{
    #[Test]
    public function testGetPublicKey(): void
    {
        $this->getAdminClient()->jsonRequest('GET', '/daemon/backend/public-key');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['public_key']);
        $this->assertSame('test-backend-public-key', $data['public_key']);
    }

    #[Test]
    public function testGetPublicKeyByDaemon(): void
    {
        $this->getDaemonClient()->jsonRequest('GET', '/daemon/backend/public-key');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $data = json_decode($this->getDaemonClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['public_key']);
        $this->assertSame('test-backend-public-key', $data['public_key']);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/backend/public-key');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $this->getHackerClient()->jsonRequest('GET', '/daemon/backend/public-key');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
