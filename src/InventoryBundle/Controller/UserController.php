<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\User;
use InventoryBundle\Form\EditUserForm;
use InventoryBundle\Form\LoginForm;
use InventoryBundle\InventoryBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\FormLoginFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
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
        $userPassword = $request->get('plainPassword');

        $user = new User();
        $user->setUsername($userName);
        $user->setPlainPassword($userPassword);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success','User Created!');

        return $this->redirectToRoute('login_form');
    }

    /**
     * @Route("/login", name="login_form")
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername
        ]);

        return $this->render('InventoryBundle:User:login.html.twig', [
            'form' => $form->createView(),
            'error'         => $error,
        ]);

    }

    /*/**
     * @param Request $request
     * @Route("/loginProcess", name="login_Process")
     *
     * @return Response
     */
    /*public function loginProcessAction(Request $request)
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

        $this->addFlash('success','User logged in!');

        return $this->redirectToRoute('inventory_page');
    }*/

    /**
     * @Route("/role", name="role")
     */
    public function rolesAction()
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepo->findAll();



        return $this->render('InventoryBundle:User:role.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/editRole/{id}", name="edit_Role")
     */
    public function editRolesAction(Request $request, $id)
    {
        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user     = $userRepo->find($id);
        $form = $this->createForm(EditUserForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('task_success', 'Role Updated');

            return $this->redirectToRoute('role', [
                'user' => $user,
                'form' => $form,
            ]);
            }


        return $this->render('@Inventory/User/edit.role.form.html.twig', [

            'form' => $form->createView(),
            'user' => $user,
        ]);

    }

   /* /**
     * @Route("/saveRole/{id}", name="save_Role")
     */
   /* public function saveRolesAction(Request $request, $id)
    {

        $userRepo  = $this->getDoctrine()->getRepository(User::class);
        $user      = $userRepo->find($id);

        $userRoles = $request->get('roles');

        $user->setRoles($userRoles);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('role');
    }*/

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');

    }

   /* /**
     * @param Request $request
     * @Route("/logoutProcess", name="logout_Process")
     *
     * @return Response
     */
   /* public function logoutProcessAction(Request $request)
    {
        $session = $this->get('session');
        $session->remove('logged_in');
        $session->remove('user_id');
        $session->clear();

        $this->addFlash('success','User logged out!');

        return $this->redirectToRoute('inventory_page');
    }*/

}
