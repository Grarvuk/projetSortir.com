<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Participant;
use App\Entity\Sortie;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{

    /**
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private $id;   

    /**
    * @ORM\Column(type="date")
    */
    private $date_inscription;
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Sortie")
    */
    private $sortie;
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Participant")
    */
    private $participant;

    public function getDateInscription()
    {
        return $this->date_inscription;
    }

    public function getSortie()
    {
        return $this->sortie;
    }

    public function getParticipant()
    {
        return $this->participant;
    }


    public function setDateInscription($date_inscription)
    {
        $this->date_inscription = $date_inscription;
    }

    public function setSortie($sortie)
    {
        $this->sortie = $sortie;
    }

    public function setParticipant($participant)
    {
        $this->participant = $participant;
    }
}
