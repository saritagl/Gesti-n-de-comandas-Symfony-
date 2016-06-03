<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_")
 */
class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="server_id", referencedColumnName="id")
     */
    private $server;

    /**
     * @ORM\ManyToOne(targetEntity="Table", inversedBy="orders")
     * @ORM\JoinColumn(name="table_id", referencedColumnName="id")
     */
    private $table;

    /**
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order")
     */
    private $items;

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
     * Set server
     *
     * @param \AppBundle\Entity\User $server
     *
     * @return Order
     */
    public function setServer(\AppBundle\Entity\User $server = null)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get server
     *
     * @return \AppBundle\Entity\User
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Set table
     *
     * @param \AppBundle\Entity\Table $table
     *
     * @return Order
     */
    public function setTable(\AppBundle\Entity\Table $table = null)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Get table
     *
     * @return \AppBundle\Entity\Table
     */
    public function getTable()
    {
        return $this->table;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setTotal(0);
    }

    /**
     * Add item
     *
     * @param \AppBundle\Entity\OrderItem $item
     *
     * @return Order
     */
    public function addItem(\AppBundle\Entity\OrderItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \AppBundle\Entity\OrderItem $item
     */
    public function removeItem(\AppBundle\Entity\OrderItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }
}
