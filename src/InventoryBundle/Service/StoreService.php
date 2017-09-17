<?php

namespace InventoryBundle\Service;

use Doctrine\ORM\EntityManager;
use InventoryBundle\Entity\Store;

/**
 * Class StoreService
 * @package InventoryBundle\Service
 */
class StoreService
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * StoreService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getAllStores()
    {
        $storeRepo = $this->em->getRepository(Store::class);
        $stores = $storeRepo->findAll();

        return $stores;
    }

}