<?php

namespace InventoryBundle\Controller;

use Doctrine\DBAL\Types\JsonArrayType;
use InventoryBundle\Entity\StoreStock;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    /**
     * @Route("/api/store-stock/{store}", name="api_store_stock")
     * @param $store
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getStoreStockDataAction($store)
    {

        $storeStockRepo = $this->getDoctrine()->getRepository(StoreStock::class);

        $data = $storeStockRepo->findBy(["store" => $store]);




        return new JsonResponse($data);
    }
}
