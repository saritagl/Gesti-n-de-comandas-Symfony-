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
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isAvailable;


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
}
