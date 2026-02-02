<?php

namespace Titanbot\Daemon\Tests\Functional\Infrastructure\Security;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ApiKeyAAuthenticatorTest extends WebTestCase
{
    protected const string HEADER_X_API_KEY = 'HTTP_X_API_KEY';
    private const string ADMIN_API_KEY = 'admin-api-key';

    #[Test]
    public function testRwMode(): void
    {
        $_ENV['IS_RO_MODE'] = '0';
        $_SERVER['IS_RO_MODE'] = '0';

        $_ENV['ADMIN_API_KEY'] = self::ADMIN_API_KEY;
        $_SERVER['ADMIN_API_KEY'] = self::ADMIN_API_KEY;

        static::ensureKernelShutdown();

        $client = static::createClient();
        $client->setServerParameter(self::HEADER_X_API_KEY, self::ADMIN_API_KEY);
        $client->jsonRequest('GET', '/daemon/devices');
        
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    #[Test]
    public function testRoMode(): void
    {
        $_ENV['IS_RO_MODE'] = '1';
        $_SERVER['IS_RO_MODE'] = '1';

        $_ENV['ADMIN_API_KEY'] = self::ADMIN_API_KEY;
        $_SERVER['ADMIN_API_KEY'] = self::ADMIN_API_KEY;

        static::ensureKernelShutdown();

        $client = static::createClient();
        $client->setServerParameter(self::HEADER_X_API_KEY, self::ADMIN_API_KEY);
        $client->jsonRequest('GET', '/daemon/devices');
        
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
