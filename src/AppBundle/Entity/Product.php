<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="product")
     */
    private $onGoingSales;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceItem", mappedBy="product")
     */
    private $sales;

    /**
     * @ORM\Column(name="image_path", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @Assert\File(maxSize="1M", mimeTypes={"image/png", "image/jpeg"})
     */
    private $file;

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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sales = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sale
     *
     * @param \AppBundle\Entity\InvoiceItem $sale
     *
     * @return Product
     */
    public function addSale(\AppBundle\Entity\InvoiceItem $sale)
    {
        $this->sales[] = $sale;

        return $this;
    }

    /**
     * Remove sale
     *
     * @param \AppBundle\Entity\InvoiceItem $sale
     */
    public function removeSale(\AppBundle\Entity\InvoiceItem $sale)
    {
        $this->sales->removeElement($sale);
    }

    /**
     * Get sales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * Add onGoingSale
     *
     * @param \AppBundle\Entity\OrderItem $onGoingSale
     *
     * @return Product
     */
    public function addOnGoingSale(\AppBundle\Entity\OrderItem $onGoingSale)
    {
        $this->onGoingSales[] = $onGoingSale;

        return $this;
    }

    /**
     * Remove onGoingSale
     *
     * @param \AppBundle\Entity\OrderItem $onGoingSale
     */
    public function removeOnGoingSale(\AppBundle\Entity\OrderItem $onGoingSale)
    {
        $this->onGoingSales->removeElement($onGoingSale);
    }

    /**
     * Get onGoingSales
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOnGoingSales()
    {
        return $this->onGoingSales;
    }
}
