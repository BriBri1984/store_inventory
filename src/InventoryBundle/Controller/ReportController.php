<?php

namespace InventoryBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    /**
     * @Route("/report", name="report")
     */
    public function storeTransactionAction()
    {
        $storeService = $this->get('service.store');
        $stores = $storeService->getAllStores();

        return $this->render("@Inventory/Report/report.html.twig", [
            'stores' => $stores,
        ]);
    }
}
