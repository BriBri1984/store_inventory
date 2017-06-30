<?php

namespace InventoryBundle\Service;

use InventoryBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use InventoryBundle\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UserService
 * @package UserBundle\Service
 */
class UserService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * @param EntityManager $em
     * @param TokenStorage $tokenStorage
     */
    public function __construct(
        EntityManager $em,
        TokenStorage $tokenStorage

    ) {
        $this->em                        = $em;
        $this->tokenStorage              = $tokenStorage;
        $this->userRepo                  = $em->getRepository(User::class);
    }

    /**
     * Returns whether the user name is taken or not
     *
     * @param $username
     *
     * @return bool
     */
    public function doesUsernameExist($username)
    {
        $username = strtolower($username);

        return count($this->userRepo->findBy(['username' => $username])) > 0;
    }

    /**
     * @param $username
     *
     * @return User|null
     */
    public function findUserByUsername($username)
    {
        return $this->userRepo->findOneBy(['username' => $username]);
    }

    /**
     * Finds the user by the user id
     *
     * @param int $userId
     *
     * @return User
     */
    public function findByUserId($userId)
    {
        return $this->userRepo->find($userId);
    }
}
