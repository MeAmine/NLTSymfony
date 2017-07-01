<?php
namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 19:54
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="behove")
 */

class Behove
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="adminGroup")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="MailingGroup", inversedBy="adminUsers")
     * @ORM\JoinColumn(name="mailing_group_id", referencedColumnName="id")
     */
    private $adminGroups;

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
     * Set users
     *
     * @param \UserBundle\Entity\User $users
     *
     * @return Behove
     */
    public function setUsers(\UserBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \UserBundle\Entity\User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set adminGroups
     *
     * @param \ClientBundle\Entity\MailingGroup $adminGroups
     *
     * @return Behove
     */
    public function setAdminGroups(\ClientBundle\Entity\MailingGroup $adminGroups = null)
    {
        $this->adminGroups = $adminGroups;

        return $this;
    }

    /**
     * Get adminGroups
     *
     * @return \ClientBundle\Entity\MailingGroup
     */
    public function getAdminGroups()
    {
        return $this->adminGroups;
    }
}
