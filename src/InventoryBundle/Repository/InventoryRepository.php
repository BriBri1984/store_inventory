<?php

namespace InventoryBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

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
            ->setParameter('searchTerm', '%'.$term.'%' )
            ->getQuery()
            ->execute();
    }
}