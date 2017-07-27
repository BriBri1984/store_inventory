<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock_quantity")
 */
class StockQuantity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\JoinColumn(name="stock_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="InventoryBundle\Entity\Stock", inversedBy="stockQuantity", fetch="EAGER")
     */
    private $stock;

    /**
     * @ORM\Column(type="integer", name="price", nullable=false)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", name="stock_quantity", nullable=false)
     */
    private $stockQuantity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return StockQuantity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     *
     * @return StockQuantity
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    /**
     * @param mixed $stockQuantity
     *
     * @return StockQuantity
     */
    public function setStockQuantity($stockQuantity)
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
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



}