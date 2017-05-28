<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/register", name="register_form")
     */
    public function registerAction()
    {
        return $this->render('InventoryBundle:User:register.html.twig', [
            // ...
        ]);
    }

    /**
     * @param Request $request
     * @Route ("/register_process", name="register_process")
     * @return Response
     */
    public function processRegistrationAction(Request $request)
    {
        $userName = $request->get('username');
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
        return $this->render('InventoryBundle:User:login.html.twig', [
            // ...
        ]);
    }

}
