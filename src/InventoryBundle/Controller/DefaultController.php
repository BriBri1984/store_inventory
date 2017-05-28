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

class DefaultController extends Controller
{

    /**
     * @Route("/", name="inventory_page")
     */
    public function inventoryPageAction()
    {
        $user    = null;
        $session = $this->get('session');

        if ($session->get('logged_in') == true) {
            $userId = $session->get('user_id');
            if (!empty($userId)) {
                $user = $this->getDoctrine()->getRepository(User::class)->find($userId);
            }
        }

        $inventoryRepository = $this->getDoctrine()->getRepository(Inventory::class);
        $storeRepository     = $this->getDoctrine()->getRepository(Store::class);
        $stores              = $storeRepository->findAll();
        $items               = $inventoryRepository->findAll();


        return $this->render('InventoryBundle:Default:index.html.twig', [
            'items'  => $items,
            'stores' => $stores,
            'user'   => $user,
        ]);
    }

    /**
     * @todo brian note that once you give a route a name you can access it in twig using the path("route_name") function
     * I added it to the form in InventoryBundle:Default:index.html.twig
     *
     * @Route("/create_inventory", name="create_inventory")
     * @param Request $request This is the dependency injected Request object. Dont overthink it, it's a part of the framework and lets you access form data, among other things
     *
     * @return Response
     */
    public function newInventoryAction(Request $request)
    {
        $storeId = $request->get('store_id_from_frontend_form');

        $store = $this->getDoctrine()->getRepository(Store::class)->find($storeId);

        $inventory = new Inventory();
        $inventory->setProductName($request->get('name'));
        $inventory->setCost($request->get('cost'));
        $inventory->setQuantity($request->get('quantity'));
        $inventory->setStore($store);

        $em = $this->getDoctrine()->getManager();
        $em->persist($inventory);
        $em->flush();

        return $this->redirectToRoute('inventory_page');
    }


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
     * @Route("/show")
     */
    public function listAction()
    {
        $em             = $this->getDoctrine()->getManager();
        $inventory_list = $em->getRepository(Inventory::class)
            ->findAll();

        return $this->render('InventoryBundle:Default:show.html.twig', [
            'inventory' => $inventory_list,
        ]);

    }


    /**
     * @Route("/stores", name="stores")
     */
    public function storesPageAction()
    {
        $storeRepository = $this->getDoctrine()->getRepository(Store::class);

        $stores = $storeRepository->findAll();

        return $this->render('InventoryBundle:Default:stores.html.twig', [
            'stores' => $stores,
        ]);
    }

    /**
     * @Route("/a1")
     */
    public function orderhistory1Action()
    {
        return $this->render('InventoryBundle:Default:a1_order_history.html.twig');
    }

    /**
     * @Route ("/edit_inventory_form/{id}", name="edit_inventory_form")
     * @return Response
     *
     *
     */
    public function editInventoryFormAction($id)
    {
        $storeRepository = $this->getDoctrine()->getRepository(Store::class);
        $stores          = $storeRepository->findAll();

        $inventoryRepository = $this->getDoctrine()->getRepository(Inventory::class);
        $inventory           = $inventoryRepository->find($id);

        return $this->render('@Inventory/Default/edit.inventory.form.html.twig', [
            'stores'    => $stores,
            'inventory' => $inventory,
        ]);
    }

    /**
     * @param Request $request
     * @param inventoryId
     * @Route("/save_inventory_edit/{inventoryId}", name="save_inventory_edit")
     *
     * @return RedirectResponse
     */
    public function saveInventoryEdit(Request $request, $inventoryId)
    {
        // find the inventory record, and get an inventory entity
        $inventoryRepo = $this->getDoctrine()->getRepository(Inventory::class);
        $inventory     = $inventoryRepo->find($inventoryId);

        // Use the $request object to get all values from the form
        $productName = $request->get('product_name');
        $cost        = $request->get('cost');
        $quantity    = $request->get('quantity');
        $storeId     = $request->get('store_id_from_frontend_form');

        // Use setters on the entity to update the values from the request object
        $inventory->setProductName($productName);
        $inventory->setCost($cost);
        $inventory->setQuantity($quantity);


        $store = $this->getDoctrine()->getRepository(Store::class)->find($storeId);
        $inventory->setStore($store);

        // persist the entity, using the entity manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($inventory);
        $em->flush();

        // redirect the user back to the home page (inventory list page) using $this->>redirectToRoute();
        return $this->redirectToRoute('inventory_page');//lol
    }

    /**
     * @param $id
     * @Route("/edit_store_form/{id}", name="edit_store_form")
     *
     * @return Response
     */
    public function editStoreFormAction($id)
    {
        $storesRepo = $this->getDoctrine()->getRepository(Store::class);
        $stores     = $storesRepo->find($id);

        return $this->render('InventoryBundle:Default:edit.store.form.html.twig', [
            'stores' => $stores,
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
