<?php
namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 19:41
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="newsletter")
 */

class Newsletter
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $template;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    protected $favorite;

    /**
     * @ORM\OneToMany(targetEntity="Email", mappedBy="newsletter")
     */
    private $emails;

    /**
     * @ORM\OneToMany(targetEntity="Referer", mappedBy="newsletters")
     */
    private $adminGroups;

    /**
     * @ORM\OneToMany(targetEntity="Concerned", mappedBy="newsletters")
     */
    private $mailingGroups;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adminGroups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mailingGroups = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set template
     *
     * @param string $template
     *
     * @return Newsletter
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Add email
     *
     * @param \ClientBundle\Entity\Email $email
     *
     * @return Newsletter
     */
    public function addEmail(\ClientBundle\Entity\Email $email)
    {
        $this->emails[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \ClientBundle\Entity\Email $email
     */
    public function removeEmail(\ClientBundle\Entity\Email $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add adminGroup
     *
     * @param \ClientBundle\Entity\Referer $adminGroup
     *
     * @return Newsletter
     */
    public function addAdminGroup(\ClientBundle\Entity\Referer $adminGroup)
    {
        $this->adminGroups[] = $adminGroup;

        return $this;
    }

    /**
     * Remove adminGroup
     *
     * @param \ClientBundle\Entity\Referer $adminGroup
     */
    public function removeAdminGroup(\ClientBundle\Entity\Referer $adminGroup)
    {
        $this->adminGroups->removeElement($adminGroup);
    }

    /**
     * Get adminGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdminGroups()
    {
        return $this->adminGroups;
    }

    /**
     * Add mailingGroup
     *
     * @param \ClientBundle\Entity\Concerned $mailingGroup
     *
     * @return Newsletter
     */
    public function addMailingGroup(\ClientBundle\Entity\Concerned $mailingGroup)
    {
        $this->mailingGroups[] = $mailingGroup;

        return $this;
    }

    /**
     * Remove mailingGroup
     *
     * @param \ClientBundle\Entity\Concerned $mailingGroup
     */
    public function removeMailingGroup(\ClientBundle\Entity\Concerned $mailingGroup)
    {
        $this->mailingGroups->removeElement($mailingGroup);
    }

    /**
     * Get mailingGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMailingGroups()
    {
        return $this->mailingGroups;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Newsletter
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
     * Set image
     *
     * @param string $image
     *
     * @return Newsletter
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Newsletter
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
     * Set favorite
     *
     * @param boolean $favorite
     *
     * @return Newsletter
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get favorite
     *
     * @return boolean
     */
    public function getFavorite()
    {
        return $this->favorite;
    }
}