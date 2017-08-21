<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\StoreStock;
use InventoryBundle\Form\StoreStockForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class StoreStockController extends Controller
{
    /**
     * @Route("store_stock", name="store_stock")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addStoreStockAction(Request $request)
    {
        $storeStock = new StoreStock();

        $form = $this->createForm(StoreStockForm::class, $storeStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($storeStock);
            $em->flush();
        }

        $storeStockRepo = $this->getDoctrine()->getRepository(StoreStock::class);
        $storeStock     = $storeStockRepo->findAll();

        return $this->render("@Inventory/StoreStock/add.store.stock.html.twig", [
            'form'       => $form->createView(),
            'storeStock' => $storeStock,
        ]);
    }
}
