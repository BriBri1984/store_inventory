<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package InventoryBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        dump($this->get('session')->all());

        return $this->render('InventoryBundle:User:login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
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
