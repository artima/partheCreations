<?php

namespace Artimone\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AnnonceSkill
 *
 * @ORM\Table(name="annonce_skill")
 * @ORM\Entity(repositoryClass="Artimone\BlogBundle\Repository\AnnonceSkillRepository")
 */
class AnnonceSkill
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
     * @ORM\Column(name="niveau", type="string", length=255)
     */
    private $niveau;
    
    /**
     * @ORM\ManyToOne(targetEntity="Artimone\BlogBundle\Entity\Annonce")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    /**
     * @ORM\ManyToOne(targetEntity="Artimone\BlogBundle\Entity\Skill")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

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
     * Set niveau
     *
     * @param string $niveau
     *
     * @return AnnonceSkill
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return string
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set annonce
     *
     * @param \Artimone\BlogBundle\Entity\Annonce $annonce
     *
     * @return AnnonceSkill
     */
    public function setAnnonce(\Artimone\BlogBundle\Entity\Annonce $annonce)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \Artimone\BlogBundle\Entity\Annonce
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }

    /**
     * Set skill
     *
     * @param \Artimone\BlogBundle\Entity\Skill $skill
     *
     * @return AnnonceSkill
     */
    public function setSkill(\Artimone\BlogBundle\Entity\Skill $skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return \Artimone\BlogBundle\Entity\Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }
}
