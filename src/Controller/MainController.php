<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Participant;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(EntityManagerInterface $em)
    {
        $repoSortie = $em->getRepository(Sortie::class);
        $Sorties = $repoSortie->findBy(["etatsortie" => 1]);
                
        return $this->render("Sorties/listSorties.html.twig", ["Sorties" => $Sorties]);
       /* return $this->render('base.html.twig', [
            'controller_name' => 'MainController',
        ]);*/
    }
}
