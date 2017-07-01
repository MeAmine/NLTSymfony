<?php
namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 21:07
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="mailing_group")
 */
class MailingGroup
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
    protected $label;

    /**
     * @ORM\OneToMany(targetEntity="Belongs", mappedBy="mailingGroups")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Behove", mappedBy="adminGroups")
     */
    private $adminUsers;

    /**
     * @ORM\OneToMany(targetEntity="Concerned", mappedBy="mailingGroups")
     */
    private $newsletters;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->newsletters = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set label
     *
     * @param string $label
     *
     * @return MailingGroup
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Add user
     *
     * @param \ClientBundle\Entity\Belongs $user
     *
     * @return MailingGroup
     */
    public function addUser(\ClientBundle\Entity\Belongs $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ClientBundle\Entity\Belongs $user
     */
    public function removeUser(\ClientBundle\Entity\Belongs $user)
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
     * Add newsletter
     *
     * @param \ClientBundle\Entity\Concerned $newsletter
     *
     * @return MailingGroup
     */
    public function addNewsletter(\ClientBundle\Entity\Concerned $newsletter)
    {
        $this->newsletters[] = $newsletter;

        return $this;
    }

    /**
     * Remove newsletter
     *
     * @param \ClientBundle\Entity\Concerned $newsletter
     */
    public function removeNewsletter(\ClientBundle\Entity\Concerned $newsletter)
    {
        $this->newsletters->removeElement($newsletter);
    }

    /**
     * Get newsletters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNewsletters()
    {
        return $this->newsletters;
    }

    /**
     * Add adminUser
     *
     * @param \ClientBundle\Entity\Behove $adminUser
     *
     * @return MailingGroup
     */
    public function addAdminUser(\ClientBundle\Entity\Behove $adminUser)
    {
        $this->adminUsers[] = $adminUser;

        return $this;
    }

    /**
     * Remove adminUser
     *
     * @param \ClientBundle\Entity\Behove $adminUser
     */
    public function removeAdminUser(\ClientBundle\Entity\Behove $adminUser)
    {
        $this->adminUsers->removeElement($adminUser);
    }

    /**
     * Get adminUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdminUsers()
    {
        return $this->adminUsers;
    }
}
