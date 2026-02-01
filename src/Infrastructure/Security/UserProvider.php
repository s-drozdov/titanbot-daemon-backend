<?php

declare(strict_types=1);

namespace Titanbot\Daemon\Infrastructure\Security;

use Override;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @implements UserProviderInterface<UserInterface>
 */
final readonly class UserProvider implements UserProviderInterface
{
    private const string ERROR_USER_NOT_FOUND = 'User not found';

    #[Override]
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        throw new UserNotFoundException(self::ERROR_USER_NOT_FOUND);
    }

    #[Override]
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    #[Override]
    public function supportsClass(string $class): bool
    {
        return UserInterface::class === $class || is_subclass_of($class, UserInterface::class);
    }
}
