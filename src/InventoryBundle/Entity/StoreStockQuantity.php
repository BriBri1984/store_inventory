<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="store_stock_quantity")
 */
class StoreStockQuantity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\JoinColumn(name="store_stock_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="InventoryBundle\Entity\StoreStock", inversedBy="storeStockQuantity", fetch="EAGER")
     */
    private $storeStock;

    /**
     * @ORM\Column(type="integer", name="price", nullable=false)
     */
    private $price;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string" , name="store_stock_quantity", nullable=false)
     */
    private $storeStockQuantity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStoreStock()
    {
        return $this->storeStock;
    }

    /**
     * @param mixed $storeStock
     */
    public function setStoreStock($storeStock)
    {
        $this->storeStock = $storeStock;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getStoreStockQuantity()
    {
        return $this->storeStockQuantity;
    }

    /**
     * @param mixed $storeStockQuantity
     */
    public function setStoreStockQuantity($storeStockQuantity)
    {
        $this->storeStockQuantity = $storeStockQuantity;
    }


}