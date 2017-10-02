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


    public function search($term)
    {
        //took it from inventory repo
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.productName LIKE :searchTerm')
//            ->leftJoin('i.store', 'store')
//            ->addSelect('store')
//            ->setParameter('searchTerm', '%' . $term . '%')
//            ->getQuery()
//            ->execute();
        return $this->createQueryBuilder('i')
            ->leftJoin('i.stock', 'stock')
            ->leftJoin('i.store', 'store')
            ->andWhere('stock.name LIKE :searchTerm
                        OR store.storeName LIKE :searchTerm')

            ->addSelect('store')
            ->setParameter('searchTerm', '%' . $term . '%')
            ->getQuery()
            ->execute();
    }


}