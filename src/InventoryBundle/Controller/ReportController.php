<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\Store;
use InventoryBundle\Entity\StoreStock;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReportController extends Controller
{
    /**
     * @Route("/report", name="report")
     */
    public function storeTransactionAction()
    {
        $storeService = $this->get('service.store');
        $stores = $storeService->getAllStores();
        dump($stores);







        return $this->render("@Inventory/Report/report.html.twig", [
            'stores' => $stores,
        ]);
    }
}
