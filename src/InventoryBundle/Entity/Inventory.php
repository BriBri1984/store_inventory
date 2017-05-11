<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Inventory
 * @package InventoryBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="symfony")
 */
class Inventory
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $product_name;

    /**
     * @ORM\Column(type="float")
     */
    protected $cost;

    /**
     * @ORM\Column(type="integer")
     */
    protected $stock_quantity;

    /**
     * @ORM\Column(type="integer")
     */
    protected $store;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;
}