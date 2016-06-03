<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="number", message="Number already taken")
 * @ORM\Table(name="table_")
 */
class Table
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="integer")
     */
    private $chairNumber;

    /**
     * @ORM\Column(name="is_available", type="boolean")
     */
    private $isAvailable;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="table_")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="table_")
     */
    private $invoices;


    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set chairNumber
     *
     * @param integer $chairNumber
     *
     * @return Table
     */
    public function setChairNumber($chairNumber)
    {
        $this->chairNumber = $chairNumber;

        return $this;
    }

    /**
     * Get chairNumber
     *
     * @return integer
     */
    public function getChairNumber()
    {
        return $this->chairNumber;
    }

    /**
     * Set isAvailable
     *
     * @param boolean $isAvailable
     *
     * @return Table
     */
    public function setIsAvailable($isAvailable)
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * Get isAvailable
     *
     * @return boolean
     */
    public function getIsAvailable()
    {
        return $this->isAvailable;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Table
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return Table
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Add invoice
     *
     * @param \AppBundle\Entity\Invoice $invoice
     *
     * @return Table
     */
    public function addInvoice(\AppBundle\Entity\Invoice $invoice)
    {
        $this->invoices[] = $invoice;

        return $this;
    }

    /**
     * Remove invoice
     *
     * @param \AppBundle\Entity\Invoice $invoice
     */
    public function removeInvoice(\AppBundle\Entity\Invoice $invoice)
    {
        $this->invoices->removeElement($invoice);
    }

    /**
     * Get invoices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }
}
