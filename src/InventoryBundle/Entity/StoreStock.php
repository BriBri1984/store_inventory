<?php


namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="store_stock")
 */
class StoreStock
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\JoinColumn(name="store_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="InventoryBundle\Entity\Store", inversedBy="storeStock", fetch="EAGER")
     */
    private $store;

    /**
     * @ORM\JoinColumn(name="stock_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="InventoryBundle\Entity\Stock", inversedBy="storeStock", fetch="EAGER")
     */
    private $stock;

    /**
     * @var StoreStockQuantity[]
     *
     * @ORM\OneToMany(targetEntity="InventoryBundle\Entity\StoreStockQuantity" , mappedBy="storeStock", fetch="EAGER")
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
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param mixed $store
     */
    public function setStore($store)
    {
        $this->store = $store;
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
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return StoreStockQuantity[]
     */
    public function getStoreStockQuantity()
    {
        return $this->storeStockQuantity;
    }

    /**
     * @param StoreStockQuantity[] $storeStockQuantity
     */
    public function setStoreStockQuantity($storeStockQuantity)
    {
        $this->storeStockQuantity = $storeStockQuantity;
    }





}