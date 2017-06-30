<?php

namespace InventoryBundle\Provider;

use InventoryBundle\Entity\User;
use InventoryBundle\Service\UserService;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserProvider
 *
 * @package UserBundle\Security\Provider
 */
class LoginUserProvider extends AbstractUserProvider implements UserProviderInterface
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserProvider constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get a user by their email address
     *
     * @param string $username This is the user's email address
     *
     * @return null|User
     */
    public function loadUserByUsername($username)
    {
        $user = $this->userService->findUserByUsername($username);

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }
}
