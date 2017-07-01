<?php
    namespace UserBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use FOS\UserBundle\Model\User as BaseUser;
    use Symfony\Component\Validator\Constraints as Assert;

    /**
     * @ORM\Entity
     * @ORM\Table(name="user")
     */
    class User extends BaseUser
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        protected $id;

        /**
         * @ORM\Column(type="string", nullable=true)
         *
         * @Assert\NotBlank(message="Entrez votre nom", groups={"Registration", "Profile"})
         * @Assert\Length(
         *     min=3,
         *     max=255,
         *     minMessage="Le nom est trop court.",
         *     maxMessage="Le nom est trop long.",
         *     groups={"Registration", "Profile"}
         * )
         */
        protected $nom;

        /**
         * @ORM\Column(type="string", nullable=true)
         *
         * @Assert\NotBlank(message="Entrez votre prénom", groups={"Registration", "Profile"})
         * @Assert\Length(
         *     min=3,
         *     max=255,
         *     minMessage="Le prénom est trop court.",
         *     maxMessage="Le prénom est trop long.",
         *     groups={"Registration", "Profile"}
         * )
         */
        protected $prenom;

        /**
         * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Departement", inversedBy="users")
         * @ORM\JoinColumn(name="departement_id", referencedColumnName="id")
         */
        private $departement;

        /**
         * @ORM\ManyToOne(targetEntity="ClientBundle\Entity\Employee", inversedBy="users")
         * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
         */
        private $employee;

        /**
         * @ORM\OneToMany(targetEntity="ClientBundle\Entity\Infos", mappedBy="user")
         */
        private $emails;

        /**
         * @ORM\OneToMany(targetEntity="ClientBundle\Entity\Behove", mappedBy="users")
         */
        private $adminGroup;

        /**
         * @ORM\OneToMany(targetEntity="ClientBundle\Entity\Belongs", mappedBy="users")
         */
        private $mailingGroups;
    
    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set departement
     *
     * @param \ClientBundle\Entity\Departement $departement
     *
     * @return User
     */
    public function setDepartement(\ClientBundle\Entity\Departement $departement = null)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return \ClientBundle\Entity\Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set employee
     *
     * @param \ClientBundle\Entity\Employee $employee
     *
     * @return User
     */
    public function setEmployee(\ClientBundle\Entity\Employee $employee = null)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \ClientBundle\Entity\Employee
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Add email
     *
     * @param \ClientBundle\Entity\Infos $email
     *
     * @return User
     */
    public function addEmail(\ClientBundle\Entity\Infos $email)
    {
        $this->emails[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \ClientBundle\Entity\Infos $email
     */
    public function removeEmail(\ClientBundle\Entity\Infos $email)
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
     * @param \ClientBundle\Entity\Behove $adminGroup
     *
     * @return User
     */
    public function addAdminGroup(\ClientBundle\Entity\Behove $adminGroup)
    {
        $this->adminGroup[] = $adminGroup;

        return $this;
    }

    /**
     * Remove adminGroup
     *
     * @param \ClientBundle\Entity\Behove $adminGroup
     */
    public function removeAdminGroup(\ClientBundle\Entity\Behove $adminGroup)
    {
        $this->adminGroup->removeElement($adminGroup);
    }

    /**
     * Get adminGroup
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdminGroup()
    {
        return $this->adminGroup;
    }

    /**
     * Add mailingGroup
     *
     * @param \ClientBundle\Entity\Belongs $mailingGroup
     *
     * @return User
     */
    public function addMailingGroup(\ClientBundle\Entity\Belongs $mailingGroup)
    {
        $this->mailingGroups[] = $mailingGroup;

        return $this;
    }

    /**
     * Remove mailingGroup
     *
     * @param \ClientBundle\Entity\Belongs $mailingGroup
     */
    public function removeMailingGroup(\ClientBundle\Entity\Belongs $mailingGroup)
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
}
