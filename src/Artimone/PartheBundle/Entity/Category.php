<?php

namespace Artimone\PartheBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Artimone\PartheBundle\Entity\Photos;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="Artimone\PartheBundle\Repository\CategoryRepository")
 */
class Category
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    /**
     *
     * @var type 
     * @ORM\OneToMany(targetEntity="Artimone\PartheBundle\Entity\Photos", mappedBy="category")
     */
    private $photos;    
    
    public function __construct() {
        $this->photos = new ArrayCollection();
    }
    
    /**
     * toString
     * @return string
     */
    public function __toString() 
    {
       return $this->getName();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Get photos
     *
     * @return string
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Add photo
     *
     * @param \Artimone\PartheBundle\Entity\Photos $photo
     *
     * @return Category
     */
    public function addPhoto(\Artimone\PartheBundle\Entity\Photos $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \Artimone\PartheBundle\Entity\Photos $photo
     */
    public function removePhoto(\Artimone\PartheBundle\Entity\Photos $photo)
    {
        $this->photos->removeElement($photo);
    }
}
