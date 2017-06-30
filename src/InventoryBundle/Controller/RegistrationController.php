<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\User;
use InventoryBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class RegistrationController
 * @package InventoryBundle\Controller
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="register_form")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function processRegistrationAction(Request $request)
    {
        $passwordEncoder = $this->get('security.password_encoder');
        $em              = $this->getDoctrine()->getManager();

        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('home_page');
        }

        return $this->render(
            '@Inventory/Register/register.html.twig',
            ['form' => $form->createView()]
        );
    }
}