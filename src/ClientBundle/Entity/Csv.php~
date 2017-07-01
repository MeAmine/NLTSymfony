<?php
    namespace ClientBundle\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;
/**
 * Created by PhpStorm.
 * User: matth
 * Date: 29/03/2017
 * Time: 13:52
 */

    /**
     * @ORM\Entity
     * @ORM\Table(name="csv")
     */
    class Csv
    {
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;

        /**
         * @ORM\Column(type="string")
         *
         * @Assert\NotBlank(message="upload un csv")
         * @Assert\File(mimeTypes={ "text/plain" })
         */
        private $csv;
    
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
     * Set csv
     *
     * @param string $csv
     *
     * @return Csv
     */
    public function setCsv($csv)
    {
        $this->csv = $csv;

        return $this;
    }

    /**
     * Get csv
     *
     * @return string
     */
    public function getCsv()
    {
        return $this->csv;
    }
}
