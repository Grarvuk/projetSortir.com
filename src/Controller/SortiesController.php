<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SortieType;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;

class SortiesController extends AbstractController
{
    /**
     * @Route("/sorties", name="sorties")
     */
    public function index()
    {
        return $this->render('sorties/index.html.twig', [
            'controller_name' => 'SortiesController',
        ]);
    }

    /**
     * @Route("/sorties/insertsortie", name="sortie_insert")
     */
    public function insertSortie(EntityManagerInterface $em, Request $request)
    {
        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $sortie->setEtatSortie(0);
            $sortie->setUrlPhoto("url");
            $sortie->setOrganisateur($this->getUser()->getId());
            $em->persist($sortie);
            $em->flush();

            $this->addFlash("success", "Sortie enregistrée");
            return $this->redirectToRoute("/");
        }

        return $this->render('sorties/insert.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }
}
