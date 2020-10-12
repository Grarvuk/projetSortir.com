<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
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
    private $nom_ville;
    /**
    * @ORM\Column(type="string", length=10)
    */
    private $code_postale;

    /** ArrayCollection
    * @var 
    * @ORM\OneToMany(targetEntity="App\Entity\Lieu", mappedBy="ville")
    */
    private $lieux;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVille()
    {
        return $this->nom_ville;
    }

    public function getCodePostale()
    {
        return $this->code_postale;
    }


    public function setNomVille($pNom_ville)
    {
        $this->nom_ville = $pNom_ville;
    }

    public function setCodePostale($pCode_postale)
    {
        $this->code_postale= $pCode_postale;
    }

    public function __toString(): string
    {
        return $this->getNomVille();
    }
}
