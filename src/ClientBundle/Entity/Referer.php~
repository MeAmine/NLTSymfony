<?php
namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 20:57
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="referer")
 */

class Referer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AdminGroup", inversedBy="newsletters")
     * @ORM\JoinColumn(name="admin_group_id", referencedColumnName="id")
     */
    private $adminGroups;

    /**
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="adminGroups")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id")
     */
    private $newsletters;

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
     * Set adminGroups
     *
     * @param \ClientBundle\Entity\AdminGroup $adminGroups
     *
     * @return Referer
     */
    public function setAdminGroups(\ClientBundle\Entity\AdminGroup $adminGroups = null)
    {
        $this->adminGroups = $adminGroups;

        return $this;
    }

    /**
     * Get adminGroups
     *
     * @return \ClientBundle\Entity\AdminGroup
     */
    public function getAdminGroups()
    {
        return $this->adminGroups;
    }

    /**
     * Set newsletters
     *
     * @param \ClientBundle\Entity\Newsletter $newsletters
     *
     * @return Referer
     */
    public function setNewsletters(\ClientBundle\Entity\Newsletter $newsletters = null)
    {
        $this->newsletters = $newsletters;

        return $this;
    }

    /**
     * Get newsletters
     *
     * @return \ClientBundle\Entity\Newsletter
     */
    public function getNewsletters()
    {
        return $this->newsletters;
    }
}
