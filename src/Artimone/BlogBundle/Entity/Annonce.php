<?php

namespace Artimone\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="Artimone\BlogBundle\Repository\AnnonceRepository")
 */
class Annonce
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
    /**
    * @ORM\Column(name="published", type="boolean")
    */
    private $published = true;

    /**
    * @ORM\OneToOne(targetEntity="Artimone\BlogBundle\Entity\Image", cascade={"persist"})
    * @ORM\JoinColumn(name="image_id", referencedColumnName="id")
    */
    private $image;
    
    /**
     * @ORM\ManyToMany(targetEntity="Artimone\BlogBundle\Entity\Gender", cascade={"persist"})
     * @ORM\JoinColumn(name="gender_id", referencedColumnName="id")
     */
    private $genders;
    
    /**
   * @ORM\OneToMany(targetEntity="Artimone\BlogBundle\Entity\Candidature", mappedBy="annonce")
   */
    private $candidatures; // Notez le « s », une annonce est liée à plusieurs candidatures
    
    /**
     * toString
     * @return string
     */
    public function __toString() 
    {
        return $this->getTitle();
    }
    
    // Comme la propriété $gender doit être un ArrayCollection,
    // On doit la définir dans un constructeur :
    public function __construct()
    {
      $this->date = new \Datetime();
      $this->genders = new ArrayCollection();
      $this->candidatures = new ArrayCollection();
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return annonce
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return annonce
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return annonce
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return annonce
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Annonce
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @param \Artimone\BlogBundle\Entity\Image|null $image
     */
    
    public function setImage(Image $image = null)
    {
      $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
      return $this->image;
    }
    
    // Notez le singulier, on ajoute une seule catégorie à la fois
    public function addGender(Gender $gender)
    {
      // Ici, on utilise l'ArrayCollection vraiment comme un tableau
      $this->genders[] = $gender;

      return $this;
    }

    public function removeGender(Gender $gender)
    {
      // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
      $this->genders->removeElement($gender);
    }

    // Notez le pluriel, on récupère une liste de catégories ici !
    public function getGenders()
    {
      return $this->genders;
    }


    /**
     * Add candidature
     *
     * @param \Artimone\BlogBundle\Entity\Candidature $candidature
     *
     * @return Annonce
     */
    public function addCandidature(\Artimone\BlogBundle\Entity\Candidature $candidature)
    {
        $this->candidatures[] = $candidature;

        return $this;
    }

    /**
     * Remove candidature
     *
     * @param \Artimone\BlogBundle\Entity\Candidature $candidature
     */
    public function removeCandidature(\Artimone\BlogBundle\Entity\Candidature $candidature)
    {
        $this->candidatures->removeElement($candidature);
    }

    /**
     * Get candidatures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCandidatures()
    {
        return $this->candidatures;
    }
}
