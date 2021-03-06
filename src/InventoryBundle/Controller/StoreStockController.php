<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\StoreStock;
use InventoryBundle\Form\StoreStockForm;
use InventoryBundle\Repository\StoreStockRepository;
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
        $form2 = $this->createForm(StoreStockForm::class);
        $form->handleRequest($request);
        $form2->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var StoreStock $data */
            $data = $form->getData();

            $stock = $data->getStock();
            $quantity = $data->getQuantity();

            $stockService = $this->get("service.store_stock");

            $canGiveStock = $stockService->canGiveStock($stock, $quantity);

            $totalPrice = $stockService->getTotalPrice($stock, $quantity);

            $data->setPrice($totalPrice);

            if ($canGiveStock) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($storeStock);
                $em->flush();
            }else{
                $this->addFlash('danger', 'No you can\'t, you can only add '. $stockService->getQuantityOnHand());


            }

        }




        $storeStockRepo = $this->getDoctrine()->getRepository(StoreStock::class);
        $storeStock = $storeStockRepo->findAll();
        return $this->render("@Inventory/StoreStock/add.store.stock.html.twig", [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'storeStock' => $storeStock,
        ]);
    }
}
