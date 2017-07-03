<?php

namespace PNL\indexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campagne
 *
 * @ORM\Table(name="campagne")
 * @ORM\Entity(repositoryClass="PNL\indexBundle\Repository\CampagneRepository")
 */
class Campagne
{
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
     * @ORM\Column(name="Nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
    * @ORM\ManyToMany(targetEntity="PNL\indexBundle\Entity\Client", cascade={"persist"})
    * @ORM\JoinTable(name="pnl_newsletter_Client")
    */
    private $Client;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Campagne
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Campagne
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Campagne
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

  public function addClient(Client $client)
  {
    // Ici, on utilise l'ArrayCollection vraiment comme un tableau
    $this->client[] = $client;
  }

  public function removeClient(Client $client)
  {
    // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument
    $this->Client->removeElement($client);
  }

    // Notez le pluriel, on récupère une liste de catégories ici !
  public function getClient()
  {
    return $this->Client;
  }
}

