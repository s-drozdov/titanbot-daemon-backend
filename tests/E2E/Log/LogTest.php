<?php

namespace Titanbot\Daemon\Tests\E2E\Log;

use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;

class LogTest extends E2eTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->getAdminClient()->jsonRequest('DELETE', '/logs');
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);
    }

    #[Test]
    public function testLifeCycle(): void
    {
        $message = '[78] f:10 94% GO is ACTIVE!';

        /** CREATE */
        $this->createLog($message);

        /** INDEX */
        $this->getAdminClient()->jsonRequest('GET', '/logs');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['log_list']);
        $this->assertStringContainsString($message, current($data['log_list'])['message']);

        /** Clear */
        $this->getAdminClient()->jsonRequest('DELETE', '/logs');
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $this->getAdminClient()->jsonRequest('GET', '/logs');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertEmpty($data['log_list']);
    }

    #[Test]
    public function testFilter(): void
    {
        $this->createLog('[38] f:10 94% Waiting team...');
        $this->createLog('[78] f:10 94% GO is ACTIVE!');

        $this->getAdminClient()->jsonRequest('GET', '/logs');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotEmpty($data['log_list']);
        $this->assertStringContainsString('[38] f:10 94% Waiting team...', current($data['log_list'])['message']);

        $this->getAdminClient()->jsonRequest('GET', '/logs?message=[78]');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotEmpty($data['log_list']);
        $this->assertSame(1, count($data['log_list']));
        $this->assertStringContainsString('[78] f:10 94% GO is ACTIVE!', current($data['log_list'])['message']);

        $this->getAdminClient()->jsonRequest('GET', '/logs?message=[38]');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotEmpty($data['log_list']);
        $this->assertSame(1, count($data['log_list']));
        $this->assertStringContainsString('[38] f:10 94% Waiting team...', current($data['log_list'])['message']);

        $this->getAdminClient()->jsonRequest('GET', '/logs?message=[39]');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertEmpty($data['log_list']);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $this->getAnonimousClient()->jsonRequest('POST', '/logs', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/logs');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $this->getHackerClient()->jsonRequest('POST', '/logs', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/logs');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessDaemon(): void
    {
        $this->getDaemonClient()->jsonRequest('POST', '/logs', ['message' => 'hi']);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);

        $this->getDaemonClient()->jsonRequest('GET', '/logs');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    private function createLog(string $message): void
    {
        $data = ['message' => $message];

        $this->getDaemonClient()->jsonRequest('POST', '/logs', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
    }
}
