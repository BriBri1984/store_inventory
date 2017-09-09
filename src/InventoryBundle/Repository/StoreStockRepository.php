<?php

namespace InventoryBundle\Repository;

use Doctrine\ORM\EntityRepository;
use InventoryBundle\Entity\Stock;

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
}