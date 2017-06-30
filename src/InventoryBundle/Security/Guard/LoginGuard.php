<?php

namespace InventoryBundle\Security\Guard;

use InventoryBundle\Entity\User;
use InventoryBundle\Service\UserService;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class LoginGuard
 *
 * @package UserBundle\Security\Guard
 */
class LoginGuard extends AbstractGuardAuthenticator
{
    /**
     * @var EncoderFactory
     */
    private $encoderFactory;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(
        EncoderFactory $encoderFactory,
        RouterInterface $router,
        UserService $userService
    ) {
        $this->encoderFactory          = $encoderFactory;
        $this->router                  = $router;
        $this->userService             = $userService;
    }

    /**
     * @param Request $request
     *
     * @return array|null
     */
    public function getCredentials(Request $request)
    {
        try {
            $post = json_decode($request->getContent(), true);
            if ($this->router->match($request->getPathInfo())['_route'] === 'security_login_check' &&
                $request->isMethod('POST') &&
                !empty($post['email']) &&
                !empty($post['password'])
            ) {
                return $post;
            }
        } catch (\Exception $ex) {
            return null;
        }

        return null;
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return UserInterface|User
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials['email']);
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @throws LogicException
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $encoder = $this->encoderFactory->getEncoder($user);
        if (empty($encoder)) {
            throw new LogicException('Password encoder was not found');
        }

        return $encoder->isPasswordValid($user->getPassword(), $credentials['password'], $user->getSalt());
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     *
     * @return JsonResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return true;
    }

    /**
     * This means the authentication failed
     *
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['message' => 'Authentication Failed'], Response::HTTP_FORBIDDEN);
    }

    /**
     * This means that the request is invalid.
     * We send Authentication Failed to not give any clues to about our system.
     *
     * @param Request $request
     * @param AuthenticationException|null $authException
     *
     * @return JsonResponse
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse(['message' => 'Authentication Failed'], Response::HTTP_FORBIDDEN);
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
