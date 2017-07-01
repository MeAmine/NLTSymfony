<?php
namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 14/03/2017
 * Time: 21:11
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="concerned")
 */
class Concerned
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Newsletter", inversedBy="mailingGroups")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id")
     */
    private $newsletters;

    /**
     * @ORM\ManyToOne(targetEntity="MailingGroup", inversedBy="newsletters")
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
     * Set newsletters
     *
     * @param \ClientBundle\Entity\Newsletter $newsletters
     *
     * @return Concerned
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

    /**
     * Set mailingGroups
     *
     * @param \ClientBundle\Entity\MailingGroup $mailingGroups
     *
     * @return Concerned
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
