<?php

namespace Titanbot\Daemon\Tests\E2E\EmpireDate;

use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Titanbot\Daemon\Domain\Entity\EmpireDate;
use Titanbot\Daemon\Domain\Helper\DateTime\DateTimeHelperInterface;
use Titanbot\Daemon\Tests\E2E\E2eTestCase;

class EmpireDateTest extends E2eTestCase
{
    #[Test]
    public function testLifeCycle(): void
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(EmpireDate::class);

        /** CREATE */
        $dt = new DateTimeImmutable()->sub(new DateInterval('P1W'))->setTime(0, 0, 0);
        $entity = $this->createEmpireDate(['date' => $dt->format(DateTimeImmutable::ATOM)]);
        $this->assertEquals($dt->format(DateTimeImmutable::ATOM), $entity->getDate()->format(DateTimeImmutable::ATOM));

        /** READ */
        $this->getAdminClient()->jsonRequest('GET', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertEquals($dt->format(DateTimeImmutable::ATOM), $data['empire_date']['date']);

        /** GET NEXT DATE */
        $this->getDaemonClient()->jsonRequest('GET', '/daemon/empire-dates-next');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getDaemonClient()->getResponse()->getContent(), true);

        $this->assertNull($data['empire_date']['date']);

        /** INDEX */
        $this->getAdminClient()->jsonRequest('GET', '/daemon/empire-dates');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);

        $this->assertNotEmpty($data['uuid_to_empire_date_map']);
        $this->assertNotEmpty(array_filter($data['uuid_to_empire_date_map'], fn (array $empireDate) => $empireDate['date'] == $dt->format(DateTimeImmutable::ATOM)));

        /** DELETE */
        $this->getAdminClient()->jsonRequest('DELETE', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $entity = $repository->findOneBy(['uuid' => $entity->getUuid()]);
        $this->assertNull($entity);
    }

    #[Test]
    public function testEmptyRequests(): void
    {
        $this->getAdminClient()->jsonRequest('POST', '/daemon/empire-dates', []);
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());

        $this->getAdminClient()->jsonRequest('DELETE', '/daemon/empire-dates');
        $this->assertFalse($this->getAdminClient()->getResponse()->isSuccessful());
    }

    #[Test]
    public function testNextEmpireDate(): void
    {
        $dateTimeHelper = static::getContainer()->get(DateTimeHelperInterface::class);

        $dt1 = new DateTimeImmutable()->sub(new DateInterval('P1W'))->setTime(0,0,0);
        $dt2 = new DateTimeImmutable()->add(new DateInterval('P1W'))->setTime(0,0,0);
        $dt3 = new DateTimeImmutable()->add(new DateInterval('P2W'))->setTime(0,0,0);

        $this->createEmpireDate(['date' => $dt1->format(DateTimeImmutable::ATOM)]);
        $entity = $this->createEmpireDate(['date' => $dt2->format(DateTimeImmutable::ATOM)]);
        $this->createEmpireDate(['date' => $dt3->format(DateTimeImmutable::ATOM)]);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/empire-dates-next');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getDaemonClient()->getResponse()->getContent(), true);
        $this->assertEquals($dateTimeHelper->getNextEmpireLimitUnixTs($dt2), $data['unix_timestamp']);

        $this->getAdminClient()->jsonRequest('DELETE', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_NO_CONTENT);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/empire-dates-next');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $data = json_decode($this->getDaemonClient()->getResponse()->getContent(), true);
        $this->assertEquals($dateTimeHelper->getNextEmpireLimitUnixTs($dt3), $data['unix_timestamp']);
    }

    #[Test]
    public function testAccessAnonimous(): void
    {
        $dt = new DateTimeImmutable()->add(new DateInterval('P1W'));
        $entity = $this->createEmpireDate(['date' => $dt->format(DateTimeImmutable::ATOM)]);

        $this->getAnonimousClient()->jsonRequest('POST', '/daemon/empire-dates', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/empire-dates-next');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('GET', '/daemon/empire-dates');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getAnonimousClient()->jsonRequest('DELETE', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessHacker(): void
    {
        $dt = new DateTimeImmutable()->sub(new DateInterval('P1W'));
        $entity = $this->createEmpireDate(['date' => $dt->format(DateTimeImmutable::ATOM)]);

        $this->getHackerClient()->jsonRequest('POST', '/daemon/empire-dates', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/empire-dates-next');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('GET', '/daemon/empire-dates');
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        $this->getHackerClient()->jsonRequest('DELETE', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function testAccessDaemon(): void
    {
        $dt = new DateTimeImmutable()->sub(new DateInterval('P1W'));
        $entity = $this->createEmpireDate(['date' => $dt->format(DateTimeImmutable::ATOM)]);

        $this->getDaemonClient()->jsonRequest('POST', '/daemon/empire-dates', []);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/empire-dates-next');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->getDaemonClient()->jsonRequest('GET', '/daemon/empire-dates');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $this->getDaemonClient()->jsonRequest('DELETE', sprintf('/daemon/empire-dates/%s', (string) $entity->getUuid()));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    private function createEmpireDate(array $data): EmpireDate
    {
        $repository = self::getContainer()->get('doctrine')->getRepository(EmpireDate::class);

        $this->getAdminClient()->jsonRequest('POST', '/daemon/empire-dates', $data);
        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $data = json_decode($this->getAdminClient()->getResponse()->getContent(), true);
        $this->assertNotNull($data['uuid']);
        $uuid = $this->uuidHelper->fromString($data['uuid']);

        /** @var EmpireDate $entity */
        $entity = $repository->findOneBy(['uuid' => $uuid]);

        $this->assertNotNull($entity);
        $this->assertEquals($uuid, $entity->getUuid());

        return $entity;
    }
}
