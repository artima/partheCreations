<?php

namespace Artimone\PartheBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Artimone\PartheBundle\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * Photos
 *
 * @ORM\Table(name="photos")
 * @ORM\Entity(repositoryClass="Artimone\PartheBundle\Repository\PhotosRepository")
 * @ORM\HasLifecycleCallbacks

 */
class Photos
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
     * @var string
     *
     * @ORM\Column(name="descPhoto", type="text")
     */
    private $descPhoto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="date")
     */
    private $creationDate;

    /**
     *
     * @var type 
     * @ORM\ManyToOne(targetEntity="Artimone\PartheBundle\Entity\Category", inversedBy="photos")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;   
    
    /**
     *
     * @var type 
     */
    private $temp;
    
     /**
      * @Assert\File(maxSize="6000000")
     */
    private $file;

    public function __construct() {
        $this->creationDate =new \DateTime();
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
     * @return Photos
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
     * Set descPhoto
     *
     * @param string $descPhoto
     *
     * @return Photos
     */
    public function setDescPhoto($descPhoto)
    {
        $this->descPhoto = $descPhoto;

        return $this;
    }

    /**
     * Get descPhoto
     *
     * @return string
     */
    public function getDescPhoto()
    {
        return $this->descPhoto;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Photos
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
    
    /**
     * Set category
     *
     * @param integer $category
     *
     * @return Photos
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }
    
     /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (is_file($this->getAbsolutePath())) {
            // store the old name to delete after the update
            $this->temp = $this->getAbsolutePath();
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }
    
    public function getFile()
    {
        return $this->file;
    }    

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $this->path = uniqid().'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        $this->setFile(null);
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if (isset($this->temp)) {
            unlink($this->temp);
        }
    }
}
