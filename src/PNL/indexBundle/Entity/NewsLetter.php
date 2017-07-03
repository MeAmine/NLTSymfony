<?php

namespace PNL\indexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsLetter
 *
 * @ORM\Table(name="news_letter")
 * @ORM\Entity(repositoryClass="PNL\indexBundle\Repository\NewsLetterRepository")
 */
class NewsLetter
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
   * @ORM\ManyToMany(targetEntity="PNL\indexBundle\Entity\campagne", cascade={"persist"})
    * @ORM\JoinTable(name="pnl_newsletter_campagne")
   */
    private $campagne;



    /**
     * @var string
     *
     * @ORM\Column(name="HtmlPath", type="string", length=255)
     */
    private $htmlPath;

     /**
     * @var string
     *
     * @ORM\Column(name="senderName", type="string", length=255)
     */
    private $senderName;

    /**
     * @var string
     *
     * @ORM\Column(name="Subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="datetime")
     */
    private $dateCreation;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

      public function addCampagne(Campagne $campagne)
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau
    $this->campagne[] = $campagne;
  }

  public function removeCampagne(Campagne $campagne)
  {
    // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
    $this->campagne->removeElement($campagne);
  }

    // Notez le pluriel, on récupère une liste de catégories ici !
  public function getCampagne()
  {
    return $this->campagne;
  }

    /**
     * Set htmlPath
     *
     * @param string $htmlPath
     *
     * @return NewsLetter
     */
    public function setHtmlPath($htmlPath)
    {
        $this->htmlPath = $htmlPath;

        return $this;
    }

    /**
     * Get htmlPath
     *
     * @return string
     */
    public function getHtmlPath()
    {
        return $this->htmlPath;
    }

    /**
     * Set senderName
     *
     * @param string $senderName
     *
     * @return NewsLetter
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;

        return $this;
    }

    /**
     * Get senderName
     *
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }


    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return NewsLetter
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return NewsLetter
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
}

