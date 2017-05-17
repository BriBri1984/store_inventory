<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Inventory
 * @package InventoryBundle\Entity
 *
 * @ORM\Entity(repositoryClass="InventoryBundle\Repository\InventoryRepository")
 * @ORM\Table(name="inventory")
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
     * @todo brian Typically properties are camelCased and field names are snake_cased
     * @ORM\Column(type="string", name="product_name", nullable=false)
     */
    protected $productName;

    /**
     * @todo brian Also include some kind of textual description for the field if applicable
     *
     * This is the marketing description for the item to assist with display and search
     *
     * @todo brian Note how the name here is the name of the field in the DB, but your code will reference the field as productDescription
     * Also note how the length property is set and the nullable flag will tell you that this field is optional
     *
     * @ORM\Column(name="product_description", type="string", length=255, nullable=true)
     *
     * @var string
     */
    protected $productDescription;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float", nullable=false)
     */
    protected $cost;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Stores")
     */
    protected $stores;

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
     * @return Inventory
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     *
     * @return Inventory
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     * @param string $productDescription
     *
     * @return Inventory
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;

        return $this;
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
     *
     * @return Inventory
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return Inventory
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * @param mixed $stores
     */
    public function setStores(Stores $stores)
    {
        $this->stores = $stores;
    }

}