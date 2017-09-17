<?php

namespace InventoryBundle\Controller;

use InventoryBundle\Entity\StoreStock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Class ApiController
 * @package InventoryBundle\Controller
 */
class ApiController extends Controller
{
    /**
     * @Route("/api/store-stock/{storeId}", name="api_store_stock")
     * @param int $storeId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getStoreStockDataAction($storeId)
    {
        $storeStockRepo = $this->getDoctrine()->getRepository(StoreStock::class);

        $data = $storeStockRepo->findBy(["store" => $storeId]);

        $serializer = $this->get('jms_serializer');
        $json       = $serializer->serialize($data, 'json');

        return new Response($json);
    }
}
