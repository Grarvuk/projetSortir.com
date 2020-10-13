<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\SortieType;
use App\Form\SortieAnnuleType;
use App\Entity\Sortie;
use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

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
    * @Route("/sorties/insertinscription", name="sortie_inscription")
    */
    public function insertInscription(EntityManagerInterface $em, Request $request)
    {
        $inscription = new Inscription();

        $repoSortie = $this->getDoctrine()->getRepository(Sortie::class);
        $sortieChoosen = $repoSortie->find($_POST["idSortie"]);

        $inscription->setSortie($sortieChoosen);
        $inscription->setParticipant($this->getUser());
        $date = new \DateTime();
        $inscription->setDateInscription($date);
        $em->persist($inscription);
        $em->flush();

        $this->addFlash("success", "inscription réussie");

        $response = new Response(
            'Content',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );

        return $response;
    }

    /**
    * @Route("/sorties/deleteinscription", name="sortie_desister")
    */
    public function deleteInscription(EntityManagerInterface $em, Request $request)
    {
        $inscription = new Inscription();

        $repoInscription = $this->getDoctrine()->getRepository(Inscription::class);

        $repoInscription->deleteInscription($this->getUser()->getId(), $_POST["idSortie"]);

        // $inscription->setSortie($sortieChoosen);
        // $inscription->setParticipant($this->getUser());
        // $date = new \DateTime();
        // $inscription->setDateInscription($date);
        // $em->persist($inscription);
        // $em->flush();

        // $this->addFlash("success", "inscription réussie");

        $response = new Response(
            'Content',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );

        return $response;
    }

    /**
    * @Route("/sorties/detailsortie/{id}", name="sortie_detail", requirements={"id": "\d+"})
    */
    public function detailSortie($id, EntityManagerInterface $em, Request $request)
    {
        // 
        $repoSortie = $this->getDoctrine()->getRepository(Sortie::class);
        $repoInscription = $this->getDoctrine()->getRepository(Inscription::class);

        $resultat = $repoInscription->estInscris($this->getUser()->getId(), $id);
        $isRegister = $resultat[0]["nbInscri"];

        $sortie = new Sortie();
        $sortie = $repoSortie->find($id);
        $user = $this->getUser();

        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $sortie->setEtatSortie(0);
            $sortie->setUrlPhoto("url");
            $em->persist($sortie);
            $em->flush();

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
            'isRegister' => $isRegister,
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
