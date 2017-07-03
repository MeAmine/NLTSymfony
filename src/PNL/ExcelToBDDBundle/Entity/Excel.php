<?php

namespace PNL\ExcelToBDDBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Excel
 *
 * @ORM\Table(name="excel")
 * @ORM\Entity(repositoryClass="PNL\ExcelToBDDBundle\Repository\ExcelRepository")
 */
class Excel
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    private $url;
      /**
     * @ORM\Column(type="string")
     *    
     * @Assert\File()
     */
    private $file;

  // On ajoute cet attribut pour y stocker le nom du fichier temporairement
  private $tempFilename;

  // On modifie le setter de File, pour prendre en compte l'upload d'un fichier lorsqu'il en existe déjà un autre
  public function setFile(UploadedFile $file)
  {
    $this->file = $file;
    // On vérifie si on avait déjà un fichier pour cette entité
    if (null !== $this->url) {
      // On sauvegarde l'extension du fichier pour le supprimer plus tard
      $this->tempFilename = $this->url;
      // On réinitialise les valeurs des attributs url et alt
      $this->url = null;
      $this->alfdsqfsdft = null;
    }
  }

  /**
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function preUpload()
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }

    // Le nom du fichier est son id, on doit juste stocker également son extension
    // Pour faire propre, on devrait renommer cet attribut en « extension », plutôt que « url »
    $this->url = 'xlsx';

    // Et on génère l'attribut alt de la balise <img>, à la valeur du nom du fichier sur le PC de l'internaute
    $this->alt = $this->file->getClientOriginalName();
  }

  /**
   * @ORM\PostPersist()
   * @ORM\PostUpdate()
   */
  public function upload($nomFichier)
  {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }

    // Si on avait un ancien fichier, on le supprime
    if (null !== $this->tempFilename) {
      $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
      if (file_exists($oldFile)) {
        unlink($oldFile);
      }
    }

    // On déplace le fichier envoyé dans le répertoire de notre choix
    $this->file->move(
      $this->getUploadRootDir(), // Le répertoire de destination
      $nomFichier.'.'.$this->url   // Le nom du fichier à créer, ici « id.extension »
    );
    $this->file=($this->getUploadRootDir().('/'.$nomFichier.'.'.$this->url));
  }

  public function getUploadDir()
  {
    // On retourne le chemin relatif vers l'image pour un navigateur
    return 'uploads/excel';
  }

  protected function getUploadRootDir()
  {
    // On retourne le chemin relatif vers l'image pour notre code PHP
    return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }

  

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
     * @return Excel
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
     * Get nom
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
}

