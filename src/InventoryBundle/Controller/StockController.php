<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Stock;
use InventoryBundle\Entity\StockQuantity;
use InventoryBundle\Form\AddQuantity;
use InventoryBundle\Form\StockType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StockController
 * @package InventoryBundle\Controller
 */
class StockController extends Controller
{
    /**
     * @Route("/stock", name="stock")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $stock = new Stock();

        $form = $this->createForm(StockType::class, $stock);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($stock);
            $em->flush();
        }

        // get all stock records
        $stockRepo = $this->getDoctrine()->getRepository(Stock::class);
        $stock = $stockRepo->findAll();

        return $this->render("@Inventory/Stock/index.html.twig", [
            'form' => $form->createView(),
            'stock'=> $stock
        ]);
    }

    /**
     * @Route("/stock/{id}/quantity", name="add_quantity")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function addQuantityAction(Request $request, $id)
    {
        $stockRepo =$this->getDoctrine()->getRepository(Stock::class);
        $stock = $stockRepo->find($id);
        $form = $this->createForm(AddQuantity::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($stock);
            $em->flush();

            $this->addFlash('success', 'Quantity Added');
        }

        return $this->render("@Inventory/StockQuantity/add_quantity.html.twig", [
            'stock' => $stock,
            'form'  => $form->createView(),
        ]);
    }

    /**
     * @Route("/stock/{id}/save_quantity", name="save_quantity")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function saveQuantityAction(Request $request, $id)
    {
        $stockRepo =$this->getDoctrine()->getRepository(Stock::class);
        $stock = $stockRepo->find($id);

        $stockQuantityRepo = $this->getDoctrine()->getRepository(StockQuantity::class);
        $stockQuantity = $stockQuantityRepo->find($stock);

        $price = $request->get('price');
        $quantity = $request->get('stock_quantity');

        $stockQuantity->setPrice($price);
        $stockQuantity->setStockQuantity($quantity);



        $em = $this->getDoctrine()->getManager();
        $em->persist($stockQuantity);
        $em->flush();

        return $this->redirectToRoute('add_quantity');

    }
}
