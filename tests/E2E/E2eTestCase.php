<?php

namespace Titanbot\Daemon\Tests\E2E;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Titanbot\Daemon\Domain\Entity\DaemonToken;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Titanbot\Daemon\Domain\Helper\Uuid\UuidHelperInterface;

class E2eTestCase extends WebTestCase
{
    protected const string HEADER_X_API_KEY = 'HTTP_X_API_KEY';
    protected const string ADMIN_API_KEY = 'admin-api-key';
    protected const string DAEMON_API_KEY = 'daemon-api-key';
    protected const string WRONG_API_KEY = 'wrong-api-key';

    protected UuidHelperInterface $uuidHelper;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();

        putenv(sprintf('ADMIN_API_KEY=%s', self::ADMIN_API_KEY));
        $this->client = static::createClient();

        $this->uuidHelper = static::getContainer()->get(UuidHelperInterface::class);

        $this->createDaemonToken();
    }

    protected function getAdminClient(): KernelBrowser
    {
        $this->client->setServerParameter(self::HEADER_X_API_KEY, self::ADMIN_API_KEY);

        return $this->client;
    }

    protected function getDaemonClient(): KernelBrowser
    {
        $this->client->setServerParameter(self::HEADER_X_API_KEY, self::DAEMON_API_KEY);

        return $this->client;
    }

    protected function getHackerClient(): KernelBrowser
    {
        $this->client->setServerParameter(self::HEADER_X_API_KEY, self::WRONG_API_KEY);

        return $this->client;
    }

    protected function getAnonimousClient(): KernelBrowser
    {
        $this->client->setServerParameters([]);

        return $this->client;
    }

    private function createDaemonToken(): void
    {
        $container = static::getContainer();

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $daemonToken = new DaemonToken(
            uuid: $this->uuidHelper->create(),
            token: self::DAEMON_API_KEY,
        );

        $entityManager->persist($daemonToken);
        $entityManager->flush();
    }
}
