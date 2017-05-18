<?php
/**
 * Created by PhpStorm.
 * User: brianmartinez
 * Date: 5/17/17
 * Time: 3:08 AM
 */

namespace InventoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="InventoryBundle\Repository\InventoryRepository")
 * @ORM\Table(name="stores")
 */
class Stores
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="store_name", type="string", nullable=false)
     */private $storeName;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", nullable=false)
     */private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="manager", type="string", nullable=false)
     */private $manager;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", nullable=false)
     */private $phoneNumber;

    /**
     * @ORM\OneToMany(targetEntity="Inventory" , mappedBy="stores")
     */
     private $inventory;
    

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
     * @return Stores
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStoreName()
    {
        return $this->storeName;
    }

    /**
     * @param mixed $storeName
     *
     * @return Stores
     */
    public function setStoreName($storeName)
    {
        $this->storeName = $storeName;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     *
     * @return Stores
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @param mixed $manager
     *
     * @return Stores
     */
    public function setManager($manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     *
     * @return Stores
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

}