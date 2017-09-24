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
     *
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
            'stock' => $stock,
        ]);
    }

    /**
     * @Route("/stock/{id}/quantity", name="add_quantity")
     * @param Request $request
     * @param $id
     *
     * @return Response
     */
    public function addQuantityAction(Request $request, $id)
    {
        $stockRepo = $this->getDoctrine()->getRepository(Stock::class);
        $stockQuantityRepo = $this->getDoctrine()->getRepository(StockQuantity::class);
        $stock = $stockRepo->find($id);
        $stockQuantity = $stockQuantityRepo->findAll();
        $form = $this->createForm(AddQuantity::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $stockQuantity = $form->getData();
            dump($stockQuantity);
            $price = $stockQuantity->getPrice();
            $price = $price * 100;
            $stockQuantity->setPrice($price);
            dump($stockQuantity);
            $stockQuantity->setStock($stock);
            $em = $this->getDoctrine()->getManager();
            $em->persist($stockQuantity);
            $em->flush();

            $this->addFlash('success', 'Quantity Added');

            return $this->redirectToRoute('stock', [
                'stock' => $stock,
                'stockQuantityRecords' => $stockQuantity,
            ]);
        }

        return $this->render("@Inventory/StockQuantity/add_quantity.html.twig", [
            'stock' => $stock,
            'form' => $form->createView(),
            'stockQuantityRecords' => $stockQuantity,

        ]);
    }
}
