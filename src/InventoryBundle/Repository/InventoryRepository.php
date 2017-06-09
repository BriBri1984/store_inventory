<?php

namespace InventoryBundle\Repository;

use Doctrine\ORM\EntityRepository;


/**
 * Class InventoryRepository
 * @package InventoryBundle\Repository
 */
class InventoryRepository extends EntityRepository
{
    public function search($term)
    {
        return $this->createQueryBuilder('inventory')
            ->andWhere('inventory.productName LIKE :searchTerm')
            ->leftJoin('inventory.store','store')
            ->addSelect('store')
            ->setParameter('searchTerm', '%'.$term.'%' )
            ->getQuery()
            ->execute();
    }
}