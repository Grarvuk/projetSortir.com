<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\SortieType;
use App\Form\SortieAnnuleType;
use App\Entity\Sortie;
use App\Entity\Etat;
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
            $repoEtat = $this->getDoctrine()->getRepository(Etat::class);
            $etat = $repoEtat->find(2);
            $sortie->setEtatSortie($etat);
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

        $this->etatSortie($sortieChoosen, $em);

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
        $repoSortie = $this->getDoctrine()->getRepository(Sortie::class);
        $sortieChoosen = $repoSortie->find($_POST["idSortie"]);

        $repoInscription = $this->getDoctrine()->getRepository(Inscription::class);

        $repoInscription->deleteInscription($this->getUser()->getId(), $_POST["idSortie"]);

        $this->etatSortie($sortieChoosen, $em);

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

        $estInscrit = $repoInscription->estInscris($this->getUser()->getId(), $id);
        $isRegister = $estInscrit[0]["nbInscri"];

        $lesInscrits = $repoInscription->lesInscrits($id);
        dump(json_encode($lesInscrits));

        $sortie = new Sortie();
        $sortie = $repoSortie->find($id);
        $user = $this->getUser();

        $sortieForm = $this->createForm(SortieType::class, $sortie);

        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            $repoEtat = $this->getDoctrine()->getRepository(Etat::class);
            $etat = $repoEtat->find(2);
            $sortie->setEtat($etat);
            $sortie->setUrlPhoto("url");
            $em->persist($sortie);
            $em->flush();
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
            'lesInscrits' => $lesInscrits,
        ]);
    }

    /**
    * @Route("/sorties/getParticipants", name="sortie_getParticipants")
    */
    public function getParticipants(EntityManagerInterface $em, Request $request)
    {
        $repoInscription = $this->getDoctrine()->getRepository(Inscription::class);

        $lesInscrits = $repoInscription->lesInscrits($_POST["idSortie"]);
        $json = json_encode($lesInscrits);

        $response = new Response(
            $json,
            Response::HTTP_OK,
            array('content-type' => 'application/json')
        );

        return $response;
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
            $repoEtat = $this->getDoctrine()->getRepository(Etat::class);
            $etat = $repoEtat->find(6);
            $sortie->setEtat($etat);
            $em->persist($sortie);
            $em->flush();

            $this->addFlash("success", "Sortie annulée");
            return $this->redirectToRoute("sorties");
        }

        return $this->render('sorties/annule.html.twig', [
            'sortieForm' => $sortieForm->createView(),
        ]);
    }

    public function etatSortie(Sortie $sortie, $em)
    {
        if(new \DateTime() > $sortie->getDatecloture()){
            $repoEtat = $this->getDoctrine()->getRepository(Etat::class);
                $etat = $repoEtat->find(8);
                $sortie->setEtat($etat);
                $em->persist($sortie);
                $em->flush();
        }else{
            $em = $this->getDoctrine()->getManager();
            $repoInscription = $em->getRepository(Inscription::class);

            $totalInscription = $repoInscription->createQueryBuilder('i')
                ->where('i.sortie = :searchTerm')
                ->setParameter('searchTerm', $sortie)
                ->select('count(i.id)')
                ->getQuery()
                ->getSingleScalarResult();

            if($totalInscription < $sortie->getNbinscriptionsmax()){
                $repoEtat = $this->getDoctrine()->getRepository(Etat::class);
                $etat = $repoEtat->find(2);
                $sortie->setEtat($etat);
                $em->persist($sortie);
                $em->flush();
            }else{
                $repoEtat = $this->getDoctrine()->getRepository(Etat::class);
                $etat = $repoEtat->find(4);
                $sortie->setEtat($etat);
                $em->persist($sortie);
                $em->flush();
            }
        }
    } 

}
