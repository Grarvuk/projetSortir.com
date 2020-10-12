<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\LieuType;
use App\Entity\Lieu;
use Symfony\Component\HttpFoundation\Request;

class LieuController extends AbstractController
{
    /**
     * @Route("/lieux/insertlieu", name="lieu_insert")
     */
    public function insertLieu(EntityManagerInterface $em, Request $request)
    {
        $lieu = new Lieu();
        $lieuForm = $this->createForm(LieuType::class, $lieu);
        
        $lieuForm->handleRequest($request);
        if($lieuForm->isSubmitted() && $lieuForm->isValid()){
            $em->persist($lieu);
            $em->flush();

            $this->addFlash("success", "Lieu enregistré");
            return $this->redirectToRoute("lieux");
        }

        return $this->render('lieu/insert.html.twig', [
            'lieuForm' => $lieuForm->createView(),
        ]);
    }

    /**
     * @Route("/lieux/lieux", name="lieux")
     */
    public function lieux()
    {
        $lieuxRepo = $this->getDoctrine()->getRepository(Lieu::class);
        $lieux = $lieuxRepo->findAll();

        return $this->render('lieu/list.html.twig', compact("lieux"));
    }

    /**
     * @Route("/lieux/lieu/{id}", name="lieu_detail", requirements={"id":"\d+"})
     */
    public function detailsLieux($id)
    {
        $lieuxRepo = $this->getDoctrine()->getRepository(Lieu::class);
        $lieu = $lieuxRepo->find($id);

        if(empty($lieu)){
            throw $this->createNotFoundException("This lieu do not exists !");
        }

        return $this->render('lieu/detail.html.twig', compact("lieu"));
    }

    /**
     * @Route("/lieux/updatelieu/{id}", name="lieu_update", requirements={"id":"\d+"})
     */
    public function updateLieu($id, EntityManagerInterface $em, Request $request)
    {
        $lieuxRepo = $this->getDoctrine()->getRepository(Lieu::class);
        $lieu = $lieuxRepo->find($id);
        $lieuForm = $this->createForm(LieuType::class, $lieu);
        
        $lieuForm->handleRequest($request);
        if($lieuForm->isSubmitted() && $lieuForm->isValid()){
            $em->persist($lieu);
            $em->flush();

            $this->addFlash("success", "Lieu modifié");
            return $this->redirectToRoute("lieux");
        }

        return $this->render('lieu/insert.html.twig', [
            'lieuForm' => $lieuForm->createView(),
        ]);
    }

    /**
     * @Route("/lieux/deletelieu/{id}", name="lieu_delete", requirements={"id":"\d+"})
     */
    public function deleteLieu($id, EntityManagerInterface $em)
    {
        $lieuxRepo = $this->getDoctrine()->getRepository(Lieu::class);
        $lieu = $lieuxRepo->find($id);

        try{
            $em->remove($lieu);
            $em->flush();
            $this->addFlash('success', "the lieu has been deleted");
        }catch(\Exception $e){
            $this->addFlash('warning', "Le lieu n'a pas été supprimé, regardez si il est présent dans une sortie. Si c'est le cas, il n'est pas possible de le supprimer.");
        }

        return $this->redirectToRoute('lieux');
    }
}
