<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\StoreStock;
use InventoryBundle\Entity\StoreStockQuantity;
use InventoryBundle\Form\AddStoreItem;
use InventoryBundle\Form\AddStoreStockQuantity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StoreStockController extends Controller
{
    /**
     * @Route("/store_stock", name="store_stock")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createStoreStockAction(Request $request)
    {
       $storeStock = new StoreStock();

       $form = $this->createForm(AddStoreItem::class, $storeStock);

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           $em = $this->getDoctrine()->getManager();
           $em->persist($storeStock);
           $em->flush();
       }

       $storeStockRepo = $this->getDoctrine()->getRepository(StoreStock::class);
       $storeStock = $storeStockRepo->findAll();

       return $this->render("@Inventory/StoreStock/store.stock.html.twig", [
           'form' => $form->createView(),
           'storeStock' => $storeStock,
       ]);
    }

    /**
     * @Route("/store_stock/{id}/quantity", name="add_store_quantity")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addQuantityAction(Request $request, $id)
    {
        $storeStockRepo = $this->getDoctrine()->getRepository(StoreStock::class);
        $storeStockQuantityRepo = $this->getDoctrine()->getRepository(StoreStockQuantity::class);
        $storeStock = $storeStockRepo->find($id);
        $storeStockQuantity = $storeStockQuantityRepo->findAll();
        $form = $this->createForm(AddStoreStockQuantity::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $storeStockQuantity = $form->getData();
            $storeStockQuantity->setStoreStock($storeStock);
            $em = $this->getDoctrine()->getManager();
            $em->persist($storeStockQuantity);
            $em->flush();

            $this->addFlash('success', 'Quantity Added');

            return $this->redirectToRoute('store_stock', [
                'storeStock' => $storeStock,
                'storeStockQuantityRecords' => $storeStockQuantity,
            ]);
        }

        return $this->render("@Inventory/StoreStock/add.store.stock.html.twig", [
            'form' => $form->createView(),
            'storeStock' => $storeStock,
            'storeStockQuantityRecords' => $storeStockQuantity,
        ]);
    }
}
