<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Security;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Titanbot\Daemon\Infrastructure\Enum\Role;
use Symfony\Component\HttpFoundation\Response;
use Titanbot\Daemon\Infrastructure\Enum\Header;
use Symfony\Component\Security\Core\User\UserInterface;
use Titanbot\Daemon\Infrastructure\Enum\UserIdentifier;
use Titanbot\Daemon\Application\Bus\Query\QueryBusInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Index\DaemonTokenIndexQuery;
use Titanbot\Daemon\Application\UseCase\Query\DaemonToken\Index\DaemonTokenIndexQueryResult;

final class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private const string ADMIN_BADGE = 'admin';
    
    public function __construct(
        /** @var QueryBusInterface<DaemonTokenIndexQuery,DaemonTokenIndexQueryResult> */
        private QueryBusInterface $queryBus,

        private string $adminApiKey,
        private bool $isRoMode,
    ) {
        /*_*/
    }

    #[Override]
    public function supports(Request $request): ?bool
    {
        return true;
    }

    #[Override]
    public function authenticate(Request $request): Passport
    {
        $apiKey = $request->headers->get(Header::ApiKey->value);

        if ($apiKey === null || $apiKey === '') {
            throw new AuthenticationException();
        }

        if (!$this->isRoMode && $apiKey === $this->adminApiKey) {
            return new SelfValidatingPassport(
                new UserBadge(
                    self::ADMIN_BADGE, 
                    fn () => new class implements UserInterface {
                        #[Override]
                        public function getRoles(): array { return [Role::Admin->value]; }
                        
                        #[Override]
                        public function getUserIdentifier(): string { return UserIdentifier::Admin->value; }
                    },
                ),
            );
        }

        return $this->authenticateByDaemonToken($apiKey);
    }

    #[Override]
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): null
    {
        return null;
    }

    #[Override]
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        return new Response($exception->getMessage(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws AuthenticationException
     */
    private function authenticateByDaemonToken(string $apiKey): Passport
    {
        /** @var DaemonTokenIndexQueryResult $result */
        $result = $this->queryBus->execute(
            new DaemonTokenIndexQuery(token: $apiKey),
        );

        $tokenList = $result->uuid_to_token_map->toArray();

        if (empty($tokenList)) {
            throw new AuthenticationException();
        }

        $daemonTokenDto = current($tokenList);

        return new SelfValidatingPassport(
            new UserBadge(
                $daemonTokenDto->token,
                fn () => new class implements UserInterface {
                    #[Override]
                    public function getRoles(): array { return [Role::Daemon->value]; }
                    
                    #[Override]
                    public function getUserIdentifier(): string { return UserIdentifier::Daemon->value; }
                },
            ),
        );
    }
}
