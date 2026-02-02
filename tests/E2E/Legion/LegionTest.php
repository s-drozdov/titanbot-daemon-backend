<?php

namespace Titanbot\Daemon\Tests\E2E\Legion;

use PHPUnit\Framework\Attributes\Test;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;
use Symfony\Component\HttpFoundation\Response;
use Titanbot\Daemon\Domain\Entity\Device\Legion;

class LegionTest extends E2eTestCase
{
    #[Test]
    public function testLifeCycle(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Legion::class);

        /** CREATE */
        $data = [
            'title' => 'Title',
            'ext_title' => 'extTitle',
            'pay_day_of_month' => 13,
        ];

        $entity = $this->createLegion($data);
        
        $this->assertSame('Title', $entity->getTitle());
        $this->assertSame('extTitle', $entity->getExtTitle());
        $this->assertSame(13, $entity->getPayDayOfMonth());

        /** READ */
        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/legions/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertSame('Title', $data['legion']['title']);
        $this->assertSame('extTitle', $data['legion']['ext_title']);
        $this->assertSame(13, $data['legion']['pay_day_of_month']);

        /** INDEX */
        $this->getAdminClient()->jsonRequest('GET', '/daemon/legions');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['uuid_to_legion_map']);
        $this->assertSame('Title', current($data['uuid_to_legion_map'])['title']);

        /** UPDATE */
        $data = [
            'title' => 'Title1',
            'ext_title' => 'extTitle2',
            'pay_day_of_month' => 14,
        ];

        $this->getAdminClient()->jsonRequest('PATCH', sprintf('/daemon/legions/%s', (string) $entity->getUuid()), $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_ACCEPTED);

        /** @var Legion $entity */
        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);

        $this->assertNotNull($entity);
        $this->assertSame('Title1', $entity->getTitle());
        $this->assertSame('extTitle2', $entity->getExtTitle());
        $this->assertSame(14, $entity->getPayDayOfMonth());

        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', sprintf('/daemon/legions/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);
        $this->assertNull($entity);
    }

    #[Test]
    public function testEmptyRequests(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/legions', []);
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());

        $this->getAdminClient()->jsonRequest('DELETE', '/daemon/legions');
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());
    }

    #[Test]
    public function testNullableFieldsCreation(): void
    {
        $data = ['title' => 'Title'];
        $entity = $this->createLegion($data);

        $this->assertSame('Title', $entity->getTitle());
        $this->assertNull($entity->getExtTitle());
        $this->assertNull($entity->getPayDayOfMonth());
    }

    #[Test]
    public function testNotFoundStatus(): void
    {
        $uuid = $this->uuidHelper->create();

        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/legions/%s', (string) $uuid));
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $entity = $this->createLegion(['title' => 'Title']);

        $this->getAnonimousClient()->jsonRequest('POST', '/daemon/legions', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', sprintf('/daemon/legions/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/legions');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        
        $this->getAnonimousClient()->jsonRequest('PATCH', sprintf('/daemon/legions/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('DELETE', sprintf('/daemon/legions/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $entity = $this->createLegion(['title' => 'Title']);

        $this->getHackerClient()->jsonRequest('POST', '/daemon/legions', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', sprintf('/daemon/legions/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/legions');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
        
        $this->getHackerClient()->jsonRequest('PATCH', sprintf('/daemon/legions/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('DELETE', sprintf('/daemon/legions/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessDaemon(): void
    {
        $entity = $this->createLegion(['title' => 'Title']);

        $this->getDaemonClient()->jsonRequest('POST', '/daemon/legions', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', sprintf('/daemon/legions/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/legions');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        
        $this->getDaemonClient()->jsonRequest('PATCH', sprintf('/daemon/legions/%s', (string) $entity->getUuid()), []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('DELETE', sprintf('/daemon/legions/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    private function createLegion(array $data): Legion
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(Legion::class);

        $this->getAdminClient()->jsonRequest('POST', '/daemon/legions', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotNull($data['uuid']);
        $uuid = $this->uuidHelper->fromString($data['uuid']);

        /** @var Legion $entity */
        $entity = $repository->findOneBy(['uuid' => $uuid]);

        $this->assertNotNull($entity);
        $this->assertEquals($uuid, $entity->getUuid());

        return $entity;
    }
}
