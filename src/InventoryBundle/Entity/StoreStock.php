<?php


namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use \DateTime;

/**
 * @ORM\Entity(repositoryClass="InventoryBundle\Repository\StoreStockRepository")
 * @ORM\Table(name="store_stock")
 */
class StoreStock
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Store
     *
     * @ORM\ManyToOne(targetEntity="InventoryBundle\Entity\Store", inversedBy="storeStock")
     */
    private $store;

    /**
     * @var Stock
     *
     * @ORM\ManyToOne(targetEntity="InventoryBundle\Entity\Stock", inversedBy="stockQuantity", fetch="EAGER")
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var DateTime
     *
     * @JMS\Type("DateTime<'m/d/Y'>")
     *
     * @ORM\Column(name="date_given", type="datetime", nullable=false)
     */
    private $dateGiven;

    /**
     * @var int
     * @ORM\Column(name="price", type="integer", nullable=false)
     */
    private $price;

    public function __construct()
    {
        $this->dateGiven = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Store
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param Store $store
     */
    public function setStore($store)
    {
        $this->store = $store;
    }

    /**
     * @return Stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param Stock $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
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
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return DateTime
     */
    public function getDateGiven()
    {
        return $this->dateGiven;
    }

    /**
     * @param DateTime $dateGiven
     */
    public function setDateGiven($dateGiven)
    {
        $this->dateGiven = $dateGiven;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

}