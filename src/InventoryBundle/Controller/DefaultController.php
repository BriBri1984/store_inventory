<?php

namespace InventoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
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
