<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\User;
use InventoryBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * Class UserController
 * @package InventoryBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/register", name="register_form")
     */
    public function registerFormAction()
    {
        return $this->render('InventoryBundle:User:register.html.twig');
    }

    /**
     * @param Request $request
     * @Route ("/register_process", name="register_process")
     *
     * @return Response
     */
    public function processRegistrationAction(Request $request)
    {
        $userName     = $request->get('username');
        $userPassword = $request->get('password');

        $user = new User();
        $user->setUsername($userName);

        $encodedPassword = $this->get('security.password_encoder')->encodePassword($user, $userPassword);
        $user->setPassword($encodedPassword);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'User Created!');

        return $this->redirectToRoute('login_form');
    }

    /**
     * @Route("/login", name="login_form")
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('InventoryBundle:User:login.html.twig', [
            'error'         => $error,
            'last_username' => $lastUsername,
        ]);

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');

    }

    /**
     * @param Request $request
     * @Route("/logoutProcess", name="logout_Process")
     *
     * @return Response
     */
    public function logoutProcessAction(Request $request)
    {
        $session = $this->get('session');
        $session->remove('logged_in');
        $session->remove('user_id');
        $session->clear();

        $this->addFlash('success', 'User logged out!');

        return $this->redirectToRoute('inventory_page');
    }

}
