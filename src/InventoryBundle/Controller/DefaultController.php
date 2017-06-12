<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Inventory;
use InventoryBundle\Entity\Store;
use InventoryBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package InventoryBundle\Controller
 */
class DefaultController extends Controller
{

    /**
     * @Route("/", name="home_page")
     */
    public function homePageAction()
    {
        $user    = null;
        $session = $this->get('session');

        if ($session->get('logged_in') == true) {
            $userId = $session->get('user_id');
            if (!empty($userId)) {
                $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            }
        }

        return $this->render('@Inventory/Default/home.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/search", name="search_page")
     * @param Request $request
     *
     * @return Response
     */
    public function searchAction(Request $request)
    {
        $user    = null;
        $session = $this->get('session');

        if ($session->get('logged_in') == true) {
            $userId = $session->get('user_id');
            if (!empty($userId)) {
                $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            }
        }

        $query = $request->query->get('q');

        $items = $this->getDoctrine()->getRepository(Inventory::class)->search($query);

        return $this->render('@Inventory/Search/search.results.html.twig', [
            'items' => $items,
            'user'  => $user,
        ]);
    }
















}
