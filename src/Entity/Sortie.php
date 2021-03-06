<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Etat;
use App\Entity\Lieu;

/**
 * @ORM\Entity(repositoryClass=SortieRepository::class)
 */
class Sortie
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
    private $nom;
    /**
    * @ORM\Column(type="date")
    */
    private $datedebut;
    /**
    * @ORM\Column(type="integer", nullable=true)
    */
    private $duree;
    /**
    * @ORM\Column(type="date")
    */
    private $datecloture;
    /**
    * @ORM\Column(type="integer")
    */
    private $nbinscriptionsmax;
    /**
    * @ORM\Column(type="string", length=500)
    */
    private $descriptioninfos;
    /**
    * @ORM\Column(type="integer", nullable=true)
    */
    private $etatsortie;
    /**
    * @ORM\Column(type="string", length=255)
    */
    private $urlPhoto;
    /**
    * @ORM\Column(type="integer")
    */
    private $organisateur ;
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Lieu")
    */
    private $lieu;
    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\Etat")
    */
    private $etat;



	public function getNom() {
		return $this->nom;
	}

	public function setNom($nom) {
		$this->nom = $nom;
	}

	public function getDatedebut() {
		return $this->datedebut;
	}

	public function setDatedebut($datedebut) {
		$this->datedebut = $datedebut;
	}

	public function getDuree() {
		return $this->duree;
	}

	public function setDuree($duree) {
		$this->duree = $duree;
	}

	public function getDatecloture() {
		return $this->datecloture;
	}

	public function setDatecloture($datecloture) {
		$this->datecloture = $datecloture;
	}

	public function getNbinscriptionsmax() {
		return $this->nbinscriptionsmax;
	}

	public function setNbinscriptionsmax($nbinscriptionsmax) {
		$this->nbinscriptionsmax = $nbinscriptionsmax;
	}

	public function getDescriptioninfos() {
		return $this->descriptioninfos;
	}

	public function setDescriptioninfos($descriptioninfos) {
		$this->descriptioninfos = $descriptioninfos;
	}

	public function getEtatsortie() {
		return $this->etatsortie;
	}

	public function setEtatsortie($etatsortie) {
		$this->etatsortie = $etatsortie;
	}

	public function getUrlPhoto() {
		return $this->urlPhoto;
	}

	public function setUrlPhoto($urlPhoto) {
		$this->urlPhoto = $urlPhoto;
	}

	public function getOrganisateur() {
		return $this->organisateur;
	}

	public function setOrganisateur($organisateur ) {
		$this->organisateur = $organisateur;
	}

	public function getlieu() {
		return $this->lieu;
	}

	public function setLieu($lieu) {
		$this->lieu = $lieu;
	}

	public function getEtat() {
		return $this->etat;
	}

	public function etat($etat) {
		$this->etat = $etat;
	}


    public function getId()
    {
        return $this->id;
    }
}
