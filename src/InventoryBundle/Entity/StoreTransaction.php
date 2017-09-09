<?php

namespace InventoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreTransaction
 *
 * @ORM\Table(name="store_transaction")
 * @ORM\Entity(repositoryClass="InventoryBundle\Repository\StoreTransactionRepository")
 */
class StoreTransaction
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="total_amount", type="integer", nullable="false")
     */
    private $totalAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="transaction_date", type="datetime", nullable="false")
     */
    private $transactionDate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set totalAmount
     *
     * @param integer $totalAmount
     *
     * @return StoreTransaction
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set transactionDate
     *
     * @param \DateTime $transactionDate
     *
     * @return StoreTransaction
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;

        return $this;
    }

    /**
     * Get transactionDate
     *
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }
}

