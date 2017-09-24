<?php

namespace InventoryBundle\Repository;

use Doctrine\ORM\EntityRepository;
use InventoryBundle\Entity\Stock;
use InventoryBundle\Entity\Store;

/**
 * Class StoreStockRepository
 * @package InventoryBundle\Repository
 */
class StoreStockRepository extends EntityRepository
{
    public function getStoreStock(Stock $stock)
    {
        return $this->findBy(['stock' => $stock]);
    }

    public function getStoreStockStore (Store $store)
    {
        return $this->findBy(['store' => $store]);
    }




}