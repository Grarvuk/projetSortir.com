<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
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
    private $libelle;


	public function getLibelle() {
		return $this->libelle;
	}

	public function  setLibelle($libelle) {
		$this->$libelle = $libelle;
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getLibelle();
    }
}
