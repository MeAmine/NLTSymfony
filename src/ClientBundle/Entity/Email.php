<?php
namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 16:31
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="email")
 */
class Email
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
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $sender;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $senderDate;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $openedDate;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $openednumber;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $clickedNumber;

    /**
     * @ORM\OneToMany(targetEntity="Infos", mappedBy="email")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Attachement", mappedBy="email")
     */
    protected $attachements;

    /**
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="emails")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id")
     */
    private $newsletter;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attachements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Email
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
     * Set content
     *
     * @param string $content
     *
     * @return Email
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
     * Set sender
     *
     * @param string $sender
     *
     * @return Email
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set senderDate
     *
     * @param \DateTime $senderDate
     *
     * @return Email
     */
    public function setSenderDate($senderDate)
    {
        $this->senderDate = $senderDate;

        return $this;
    }

    /**
     * Get senderDate
     *
     * @return \DateTime
     */
    public function getSenderDate()
    {
        return $this->senderDate;
    }

    /**
     * Set openedDate
     *
     * @param \DateTime $openedDate
     *
     * @return Email
     */
    public function setOpenedDate($openedDate)
    {
        $this->openedDate = $openedDate;

        return $this;
    }

    /**
     * Get openedDate
     *
     * @return \DateTime
     */
    public function getOpenedDate()
    {
        return $this->openedDate;
    }

    /**
     * Set openednumber
     *
     * @param integer $openednumber
     *
     * @return Email
     */
    public function setOpenednumber($openednumber)
    {
        $this->openednumber = $openednumber;

        return $this;
    }

    /**
     * Get openednumber
     *
     * @return integer
     */
    public function getOpenednumber()
    {
        return $this->openednumber;
    }

    /**
     * Set clickedNumber
     *
     * @param integer $clickedNumber
     *
     * @return Email
     */
    public function setClickedNumber($clickedNumber)
    {
        $this->clickedNumber = $clickedNumber;

        return $this;
    }

    /**
     * Get clickedNumber
     *
     * @return integer
     */
    public function getClickedNumber()
    {
        return $this->clickedNumber;
    }

    /**
     * Add user
     *
     * @param \ClientBundle\Entity\Infos $user
     *
     * @return Email
     */
    public function addUser(\ClientBundle\Entity\Infos $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ClientBundle\Entity\Infos $user
     */
    public function removeUser(\ClientBundle\Entity\Infos $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add attachement
     *
     * @param \ClientBundle\Entity\Attachement $attachement
     *
     * @return Email
     */
    public function addAttachement(\ClientBundle\Entity\Attachement $attachement)
    {
        $this->attachements[] = $attachement;

        return $this;
    }

    /**
     * Remove attachement
     *
     * @param \ClientBundle\Entity\Attachement $attachement
     */
    public function removeAttachement(\ClientBundle\Entity\Attachement $attachement)
    {
        $this->attachements->removeElement($attachement);
    }

    /**
     * Get attachements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttachements()
    {
        return $this->attachements;
    }

    /**
     * Set newsletter
     *
     * @param \ClientBundle\Entity\Newsletter $newsletter
     *
     * @return Email
     */
    public function setNewsletter(\ClientBundle\Entity\Newsletter $newsletter = null)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return \ClientBundle\Entity\Newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
}
