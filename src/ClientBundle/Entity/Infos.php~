<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 16:16
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="infos")
 */
class Infos
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isReceived;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $isOpened;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="emails")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Email", inversedBy="users")
     * @ORM\JoinColumn(name="email_id", referencedColumnName="id")
     */
    private $email;

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
     * Set isReceived
     *
     * @param boolean $isReceived
     *
     * @return Infos
     */
    public function setIsReceived($isReceived)
    {
        $this->isReceived = $isReceived;

        return $this;
    }

    /**
     * Get isReceived
     *
     * @return boolean
     */
    public function getIsReceived()
    {
        return $this->isReceived;
    }

    /**
     * Set isOpened
     *
     * @param boolean $isOpened
     *
     * @return Infos
     */
    public function setIsOpened($isOpened)
    {
        $this->isOpened = $isOpened;

        return $this;
    }

    /**
     * Get isOpened
     *
     * @return boolean
     */
    public function getIsOpened()
    {
        return $this->isOpened;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return Infos
     */
    public function setUser(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set email
     *
     * @param \ClientBundle\Entity\Email $email
     *
     * @return Infos
     */
    public function setEmail(\ClientBundle\Entity\Email $email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return \ClientBundle\Entity\Email
     */
    public function getEmail()
    {
        return $this->email;
    }
}
