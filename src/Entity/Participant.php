<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Campus;

/**
 * @ORM\Entity(repositoryClass=ParticipantRepository::class)
 */
class Participant
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
    private $pseudo;

    /**
    * @ORM\Column(type="string", length=30)
    */
    private $nom;

    /**
    * @ORM\Column(type="string", length=30)
    */
    private $prenom;

    /**
    * @ORM\Column(type="string", length=15)
    */
    private $telephone;

    /**
    * @ORM\Column(type="string", length=30)
    */
    private $mail;

    /**
    * @ORM\Column(type="string", length=255)
    */
    private $mot_de_passe;

    /**
    * @ORM\Column(type="boolean")
    */
    private $administrateur;

    /**
    * @ORM\Column(type="boolean")
    */
    private $actif;


    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Campus", inversedBy="participants")
    */
    private $campus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?String
    {
        return $this->pseudo;
    }

    public function getnom(): ?String
    {
        return $this->nom;
    }

    public function getPrenom(): ?String
    {
        return $this->prenom;
    }

    public function getTelephone(): ?String
    {
        return $this->telephone;
    }

    public function getMail(): ?String
    {
        return $this->mail;
    }

    public function getMdp(): ?String
    {
        return $this->mot_de_passe;
    }

    public function getAdministrateur(): ?int
    {
        return $this->administrateur;
    }

    public function getActif(): ?int
    {
        return $this->actif;
    }

    public function getCampus()
    {
        return $this->campus;
    }

    ///////////Setter///////////
    ///////////Setter///////////
    ///////////Setter///////////

    public function setPseudo($pPseudo)
    {
        $this->pseudo = $pPseudo;
    }

    public function setNom($pNom)
    {
        $this->nom = $pNom;
    }

    public function setPrenom($pPrenom)
    {
        $this->prenom = $pPrenom;
    }
    public function setTelephone($pTelephone)
    {
        $this->telephone = $pTelephone;
    }
    public function setMail($pMail)
    {
        $this->mail = $pMail;
    }
    public function setMdp($pMdp)
    {
        $this->mot_de_passe = $pMdp;
    }
    public function setAdministrateur($pAdministrateur)
    {
        $this->administrateur = $pAdministrateur;
    }
    public function setActif($pActif)
    {
        $this->actif = $pActif;
    }

    public function setCampus($pCampus)
    {
        $this->campus = $pCampus;
    }
}
