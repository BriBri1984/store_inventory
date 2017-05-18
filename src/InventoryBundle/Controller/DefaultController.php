<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Inventory;
use InventoryBundle\Entity\Stores;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpCache\Store;

class DefaultController extends Controller
{
    /**
     * @todo brian note that once you give a route a name you can access it in twig using the path("route_name") function
     * I added it to the form in InventoryBundle:Default:index.html.twig
     *
     * @Route("/new", name="create_product")
     * @param Request $request This is the dependency injected Request object. Dont overthink it, it's a part of the framework and lets you access form data, among other things
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
//        You can use the dump function to debug things
//        dump($request->request->all());
//        die();

        $stores = new Stores();
        $stores->setStoreName($request->get('name'));
        $stores->setLocation($request->get('location'));
        $stores->setManager($request->get('manager'));
        $stores->setPhoneNumber($request->get('phone'));

        $inventory = new Inventory();
        $inventory->setProductName($request->get('name'));
        $inventory->setCost($request->get('cost'));
        $inventory->setQuantity($request->get('quantity'));
        $inventory->setStores($stores);

        $em = $this->getDoctrine()->getManager();
        $em->persist($stores);
        $em->persist($inventory);
        $em->flush();

        //You can redirect them back to the homepage, because we are now going to show a list of products there
        // This list will include the newly added item
        return $this->redirectToRoute('home_page');

        //return new Response('<html><body>Inventory created</body></html>');
    }


    /**
     * @Route(name="create_store", path="/create_store", methods={"POST"})
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function createStoreAction(Request $request)
    {
        $store = new Stores();
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
        $inventory_list = $em->getRepository('InventoryBundle:Inventory')
            ->findAll();

        return $this->render('InventoryBundle:Default:show.html.twig', [
            'inventory' => $inventory_list,
        ]);

    }

    /**
     * @Route("/", name="home_page")
     */
    public function homePageAction()
    {
        $inventoryRepository = $this->getDoctrine()->getRepository('InventoryBundle:Inventory');

        $items = $inventoryRepository->findAll();

        return $this->render('InventoryBundle:Default:index.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @Route("/stores", name="stores")
     */
    public function storesPageAction()
    {
        $storeRepository = $this->getDoctrine()->getRepository('InventoryBundle:Stores');

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
}
