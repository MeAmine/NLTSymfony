<?php
namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 21:05
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="belongs")
 */
class Belongs
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="mailingGroups")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="MailingGroup", inversedBy="users")
     * @ORM\JoinColumn(name="mailing_group_id", referencedColumnName="id")
     */
    private $mailingGroups;

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
     * @return Belongs
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
     * Set mailingGroups
     *
     * @param \ClientBundle\Entity\MailingGroup $mailingGroups
     *
     * @return Belongs
     */
    public function setMailingGroups(\ClientBundle\Entity\MailingGroup $mailingGroups = null)
    {
        $this->mailingGroups = $mailingGroups;

        return $this;
    }

    /**
     * Get mailingGroups
     *
     * @return \ClientBundle\Entity\MailingGroup
     */
    public function getMailingGroups()
    {
        return $this->mailingGroups;
    }
}
