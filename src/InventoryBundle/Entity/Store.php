<?php

namespace InventoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="InventoryBundle\Repository\InventoryRepository")
 * @ORM\Table(name="store")
 */
class Store
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
     * @ORM\Column(name="store_name", type="string", nullable=false)
     */
    private $storeName;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", nullable=false)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="manager", type="string", nullable=false)
     */
    private $manager;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", nullable=false)
     */
    private $phoneNumber;




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
     * @return Store
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
     * @return Store
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
     * @return Store
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
     * @return Store
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
     * @return Store
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }




}