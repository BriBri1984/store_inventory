<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stock")
 */
class Stock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="date")
     */
    private $date;


    /**
     * @var StockQuantity[]
     *
     * @ORM\OneToMany(targetEntity="InventoryBundle\Entity\StockQuantity" , mappedBy="stock", fetch="EAGER")
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
     * @return Stock
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Stock
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return Stock
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return StockQuantity[]
     */
    public function getStockQuantity()
    {
        return $this->stockQuantity;
    }

    /**
     * @param StockQuantity[] $stockQuantity
     *
     * @return Stock
     */
    public function setStockQuantity($stockQuantity)
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    /**
     * Calculate the amount of stock we have by summing all StockQuantity
     *
     * @return int
     */
    public function getQuantity()
    {
        $quantity = 0;

        if (!empty($this->stockQuantity)) {

            foreach ($this->stockQuantity as $stockQuantity) {
                $quantity += $stockQuantity->getStockQuantity();
            }
        }

        return $quantity;
    }

    /**
     * Get the average price of this item
     *
     * @return float|null
     */
    public function getAveragePrice()
    {
        $averagePrice = 0;

        if (!empty($this->stockQuantity)) {

            foreach ($this->stockQuantity as $stockQuantity) {
                $averagePrice += $stockQuantity->getPrice();
            }

            $averagePrice = $averagePrice / count($this->stockQuantity);
        }

        return $averagePrice;
    }
}