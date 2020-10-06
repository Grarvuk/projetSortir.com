<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Participant;

/**
 * @ORM\Entity(repositoryClass=CampusRepository::class)
 */
class Campus
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
    private $nom_campus;

    /** ArrayCollection
    * @var 
    * @ORM\OneToMany(targetEntity="App\Entity\Participant", mappedBy="campus")
    */
    private $participants;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCampus(): ?String
    {
        return $this->nom_campus;
    }

    public function getParticipants(): ?String
    {
        return $this->participants;
    }



    public function setNomCampus($pNomCampus)
    {
        $this->nom_campus = $pNomCampus;
    }

    public function setParticipants($pParticipants)
    {
        $this->participants = $pParticipants;
    }
}
