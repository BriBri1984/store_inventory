<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Inventory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/new")
     */
    public function newAction()
    {
        $inventory = new Inventory();
        $inventory->setProductName('Mr.Clean');
        $inventory->setCost(2.99);

        $em = $this->getDoctrine()->getManager();
        $em->persist($inventory);
        $em->flush();

        return new Response('<html><body>Inventory created</body></html>');
    }

    /**
     * @Route("/show")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $inventory_list = $em->getRepository('InventoryBundle:Inventory')
            ->findAll();

        return $this->render('InventoryBundle:Default:show.html.twig', [
            'inventory' => $inventory_list,
        ]);

    }

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('InventoryBundle:Default:index.html.twig');
    }

    /**
     * @Route("/charge")
     */
    public function chargeAction()
    {
        return $this->render('InventoryBundle:Default:charge_store.html.twig');
    }

    /**
     * @Route("/a1")
     */
    public function  orderhistory1Action()
    {
        return $this->render('InventoryBundle:Default:a1_order_history.html.twig');
    }
}
