<?php


namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="master_inventory")
 */
class MasterInventory
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="product_name", type="string")
     */
    private $productName;

    /**
     * @ORM\Column(name="cost", type="float")
     */
    private $cost;

    /**
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(name="date_ordered", type="date")
     */
    private $dateOrdered;

    /**
     * @ORM\Column(name="date_received", type="date")
     */
    private $dateReceived;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param mixed $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getDateOrdered()
    {
        return $this->dateOrdered;
    }

    /**
     * @param \DateTime $dateOrdered
     */
    public function setDateOrdered(\DateTime $dateOrdered)
    {
        $this->dateOrdered = $dateOrdered;
    }

    /**
     * @return mixed
     */
    public function getDateReceived()
    {
        return $this->dateReceived;
    }

    /**
     * @param \DateTime $dateReceived
     */
    public function setDateReceived(\DateTime $dateReceived)
    {
        $this->dateReceived = $dateReceived;
    }


}