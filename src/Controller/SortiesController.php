<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SortieType;
use App\Form\SortieAnnuleType;
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
            $sortie->setOrganisateur($this->getUser());
            $em->persist($sortie);
            $em->flush();

            $this->addFlash("success", "Sortie enregistrée");
            return $this->redirectToRoute("/");
        }

        return $this->render('sorties/insert.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }

    /**
    * @Route("/sorties/detailsortie/{id}", name="sortie_detail", requirements={"id": "\d+"})
    */
    public function detailSortie($id, EntityManagerInterface $em, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Sortie::class);

        $sortie = new Sortie();
        $sortie = $repo->find($id);

        $user = $this->getUser();

        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $sortie->setEtatSortie(0);
            $sortie->setUrlPhoto("url");
            $em->persist($sortie);
            $em->flush();

            $this->addFlash("success", "Sortie modifiée");
            // return $this->redirectToRoute("/");
        }

        if($user->getId()==$sortie->getOrganisateur()->getId())
        {
            $isOrganisateur = 1;
        }
        else
        {
            $isOrganisateur = 0;
        }
        
        return $this->render('sorties/detailSortie.html.twig', [
            'sortie' => $sortie,
            'isOrganisateur' => $isOrganisateur,
            'sortieForm' => $sortieForm->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/sorties/annulesortie/{id}", name="sortie_annule", requirements={"id": "\d+"})
     */
    public function annuleSortie($id, EntityManagerInterface $em, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $repo->find($id);
        $sortieForm = $this->createForm(SortieAnnuleType::class, $sortie);

        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $sortie->setEtatSortie(5);
            $em->persist($sortie);
            $em->flush();

            $this->addFlash("success", "Sortie annulée");
            return $this->redirectToRoute("sorties");
        }

        return $this->render('sorties/annule.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }
}
