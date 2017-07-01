<?php
namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 20:02
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="admin_group")
 */

class AdminGroup
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
     * @ORM\OneToMany(targetEntity="Referer", mappedBy="adminGroups")
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
     * @return AdminGroup
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
     * @param \ClientBundle\Entity\Behove $user
     *
     * @return AdminGroup
     */
    public function addUser(\ClientBundle\Entity\Behove $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \ClientBundle\Entity\Behove $user
     */
    public function removeUser(\ClientBundle\Entity\Behove $user)
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
     * @param \ClientBundle\Entity\Referer $newsletter
     *
     * @return AdminGroup
     */
    public function addNewsletter(\ClientBundle\Entity\Referer $newsletter)
    {
        $this->newsletters[] = $newsletter;

        return $this;
    }

    /**
     * Remove newsletter
     *
     * @param \ClientBundle\Entity\Referer $newsletter
     */
    public function removeNewsletter(\ClientBundle\Entity\Referer $newsletter)
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
}
