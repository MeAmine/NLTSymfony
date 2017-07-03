<?php

namespace PNL\indexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="PNL\indexBundle\Repository\ClientRepository")
 */
class Client
{
    /**
   * @ORM\ManyToMany(targetEntity="PNL\indexBundle\Entity\Groupe", cascade={"persist"})
    * @ORM\JoinTable(name="pnl_client_groupe")
   */
    private $groupe;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="entreprise", type="string", length=255, nullable=true)
     */
    private $entreprise;

    /**
     * @var bool
     *
     * @ORM\Column(name="isClient", type="boolean")
     */
    private $isClient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="datetime", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=255)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

      /**
   * @ORM\ManyToOne(targetEntity="PNL\indexBundle\Entity\Pays")
   * @ORM\JoinColumn(nullable=true)
   */
    private $pays;


    /**
     * Get id
     *
     * @return int
     */
    public function __construct()
    {
        $this->dateNaissance = new \DateTime('01-01-1950');
    }
// Notez le singulier, on ajoute une seule catégorie à la fois
  public function addGroupe(Groupe $groupe)
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau
    $this->groupe[] = $groupe;
  }

  public function removeGroupe(Groupe $groupe)
  {
    // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
    $this->groupe->removeElement($groupe);
  }

  // Notez le pluriel, on récupère une liste de catégories ici !
  public function getGroupe()
  {
    return $this->groupe;
  }



    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Client
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
     * @return Client
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
     * Set email
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set entreprise
     *
     * @param string $entreprise
     *
     * @return Client
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return string
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Set isClient
     *
     * @param boolean $isClient
     *
     * @return Client
     */
    public function setIsClient($isClient)
    {
        $this->isClient = $isClient;

        return $this;
    }

    /**
     * Get isClient
     *
     * @return bool
     */
    public function getIsClient()
    {
        return $this->isClient;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Client
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return Client
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Client
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

  public function setPays(Pays $pays)
  {
    $this->pays = $pays;

    return $this;
  }

  public function Pays()
  {
    return $this->pays;
  }

}

