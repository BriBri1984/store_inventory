<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Stock;
use InventoryBundle\Form\StockType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     */
    public function addQuantityAction(Request $request, $id)
    {

    }
}
