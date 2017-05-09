<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class InventoryController extends Controller
{
    /**
     * @Route("/", name="inventory")
     */
    public function inventoryAction(Request $request)
    {
        return $this->render('inventory/index.html.twig');
    }


}