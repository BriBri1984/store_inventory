<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Stock;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SandBoxController extends Controller
{
    /**
     * @Route("/sand_box",name="sand_box")
     *
     *
     */
    public function indexAction()
    {
        $stockRepo = $this->getDoctrine()->getRepository(Stock::class);
        $stock = $stockRepo->findAll();
        dump($stock); die;
    }
}
