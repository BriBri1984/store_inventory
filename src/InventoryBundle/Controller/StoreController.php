<?php

namespace InventoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use InventoryBundle\Entity\Store;
use Symfony\Component\HttpFoundation\Response;
use InventoryBundle\Entity\User;

/**
 * Class StoreController
 * @package InventoryBundle\Controller
 */
class StoreController extends Controller
{
    /**
     * @Route(name="create_store", path="/create_store", methods={"POST"})
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function createStoreAction(Request $request)
    {
        $store = new Store();
        $store->setStoreName($request->get('name'));
        $store->setLocation($request->get('location'));
        $store->setManager($request->get('manager'));
        $store->setPhoneNumber($request->get('phone'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($store);
        $em->flush();

        return $this->redirectToRoute('stores');
    }

    /**
     * @Route("/stores", name="stores")
     */
    public function storesPageAction()
    {
        $user    = null;
        $session = $this->get('session');

        if ($session->get('logged_in') == true) {
            $userId = $session->get('user_id');
            if (!empty($userId)) {
                $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            }
        }

        $storeRepository = $this->getDoctrine()->getRepository(Store::class);

        $stores = $storeRepository->findAll();

        return $this->render('InventoryBundle:Store:stores.html.twig', [
            'stores' => $stores,
            'user'   => $user,
        ]);
    }

    /**
     * @param $id
     * @Route("/edit_store_form/{id}", name="edit_store_form")
     *
     * @return Response
     */
    public function editStoreFormAction($id)
    {
        $user    = null;
        $session = $this->get('session');

        if ($session->get('logged_in') == true) {
            $userId = $session->get('user_id');
            if (!empty($userId)) {
                $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            }
        }

        $storesRepo = $this->getDoctrine()->getRepository(Store::class);
        $stores     = $storesRepo->find($id);

        return $this->render('InventoryBundle:Store:edit.store.form.html.twig', [
            'stores' => $stores,
            'user'   => $user,
        ]);

    }

    /**
     * @param Request $request
     * @param id
     * @Route("/save_store_edit/{id}", name="save_store_edit")
     *
     * @return RedirectResponse
     */
    public function saveStoreEdit(Request $request, $id)
    {
        $storeRepo = $this->getDoctrine()->getRepository(Store::class);
        $store     = $storeRepo->find($id);

        $storeName   = $request->get('store_name');
        $location    = $request->get('location');
        $manager     = $request->get('manager');
        $phoneNumber = $request->get('phone');

        $store->setStoreName($storeName);
        $store->setLocation($location);
        $store->setManager($manager);
        $store->setPhoneNumber($phoneNumber);

        $em = $this->getDoctrine()->getManager();
        $em->persist($store);
        $em->flush();

        return $this->redirectToRoute('stores');
    }

}