<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ville;

/**
 * @ORM\Entity(repositoryClass=LieuRepository::class)
 */
class Lieu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string", length=30)
    */
    private $nom_lieu;
    /**
    * @ORM\Column(type="string", length=30)
    */
    private $rue;
    /**
    * @ORM\Column(type="float", nullable=true)
    */
    private $latitude;
    /**
    * @ORM\Column(type="float", nullable=true)
    */
    private $longitude;
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="lieux")
    */
    private $ville;

    public function getId()
    {
        return $this->id;
    }

    public function getNomLieu()
    {
        return $this->nom_lieu;
    }

    public function getRue()
    {
        return $this->rue;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getVille()
    {
        return $this->ville;
    }


    ///////////Setter//////////
    ///////////Setter//////////
    ///////////Setter//////////

    public function setNomLieu($nom_lieu)
    {
        $this->nom_lieu;
    }

    public function setRue($rue)
    {
        $this->rue = $rue;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
    }
}
