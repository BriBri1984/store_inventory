<?php

namespace InventoryBundle\Service;

use Doctrine\ORM\EntityManager;
use InventoryBundle\Entity\Stock;
use InventoryBundle\Entity\Store;
use InventoryBundle\Entity\StoreStock;
use InventoryBundle\Repository\StoreStockRepository;

/**
 * Class StockService
 * @package InventoryBundle\Service
 */
class StockService
{
    /**
     * @var EntityManager
     */
    private $em;
    private $quantityOnHand;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

    }

    public function canGiveStock(Stock $stock, int $quantity)
    {
        $stockQuantity = $stock->getQuantity();

        $storeStockRepository = $this->em->getRepository(StoreStock::class);

        $storeStocks = $storeStockRepository->getStoreStock($stock);

        $quantityThatIsInAllStores = 0;

        foreach ($storeStocks as $storeStock) {
            $quantityThatIsInAllStores += $storeStock->getQuantity();
        }

        $quantityOnHand = $stockQuantity - $quantityThatIsInAllStores;
        $this->quantityOnHand = $quantityOnHand;
        if ($quantityOnHand > $quantity) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @return mixed
     */
    public function getQuantityOnHand()
    {
        return $this->quantityOnHand;
    }

    public function getTotalPrice(Stock $stock, int $quantity)
    {
        return $stock->getAveragePrice() * $quantity;
    }



}