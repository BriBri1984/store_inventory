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
     * @Route("/register", name="register_form")
     */
    public function registerAction()
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
        $user->setPassword($userPassword);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('login_form');
    }

    /**
     * @Route("/login", name="login_form")
     */
    public function loginAction()
    {
        return $this->render('InventoryBundle:User:login.html.twig');
    }

    /**
     * @param Request $request
     * @Route("/loginProcess", name="login_Process")
     *
     * @return Response
     */
    public function loginProcessAction(Request $request)
    {
        //Collect the username and password
        $userName     = $request->get('username');
        $userPassword = $request->get('password');

        //find a user entity that matches this password
        $user = $this->getDoctrine()->getRepository('InventoryBundle:User')->findOneBy(
            [
                'username' => $userName,
                'password' => $userPassword,
            ]
        );

        if (empty($user)) {
            die('Not auth');
        }

        $session = $this->get('session');
        $session->set('logged_in', true);
        $session->set('user_id', $user->getId());

        $session->save();

        return $this->redirectToRoute('inventory_page');
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

        return $this->redirectToRoute('inventory_page');
    }

}
