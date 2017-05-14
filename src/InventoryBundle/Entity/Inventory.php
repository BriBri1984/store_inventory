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
     * @todo brian Typically properties are camelCased and field names are snake_cased
     * @ORM\Column(type="string")
     */
    protected $product_name;

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
     * @ORM\Column(type="float")
     */
    protected $cost;

    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->product_name;
    }

    /**
     * @param mixed $product_name
     */
    public function setProductName($product_name)
    {
        $this->product_name = $product_name;
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


}