<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\VilleType;
use App\Entity\Ville;
use Symfony\Component\HttpFoundation\Request;

class VilleController extends AbstractController
{
    /**
     * @Route("/villes/insertville", name="ville_insert")
     */
    public function insertVille(EntityManagerInterface $em, Request $request)
    {
        $ville = new Ville();
        $villeForm = $this->createForm(VilleType::class, $ville);
        
        $villeForm->handleRequest($request);
        if($villeForm->isSubmitted() && $villeForm->isValid()){
            try{
                $em->persist($ville);
                $em->flush();
                $this->addFlash("success", "La ville a été créée.");
            }catch(\Exception $e){
                $this->addFlash('warning', "La ville n'a pas été créée, une erreur est arrivée.");
            }
            return $this->redirectToRoute("villes");
        }

        return $this->render('ville/insert.html.twig', [
            'villeForm' => $villeForm->createView(),
        ]);
    }

    /**
     * @Route("/villes/villes", name="villes")
     */
    public function villes()
    {
        $villesRepo = $this->getDoctrine()->getRepository(Ville::class);
        $villes = $villesRepo->findAll();

        if(empty($villes)){
            $this->addFlash('warning', "Il n'y a aucune villes dans la base de données.");
            return $this->redirectToRoute("ville_insert");
        }

        return $this->render('ville/list.html.twig', compact("villes"));
    }

    /**
     * @Route("/villes/ville/{id}", name="ville_detail", requirements={"id":"\d+"})
     */
    public function detailsVille($id)
    {
        $villesRepo = $this->getDoctrine()->getRepository(Ville::class);
        $ville = $villesRepo->find($id);

        if(empty($ville)){
            $this->addFlash('warning', "Cette ville n'existe pas dans la base de données.");
            return $this->redirectToRoute("villes");
        }

        return $this->render('ville/detail.html.twig', compact("ville"));
    }

    /**
     * @Route("/villes/updateville/{id}", name="ville_update", requirements={"id":"\d+"})
     */
    public function updateVille($id, EntityManagerInterface $em, Request $request)
    {
        $villesRepo = $this->getDoctrine()->getRepository(Ville::class);
        $ville = $villesRepo->find($id);

        if(empty($ville)){
            $this->addFlash('warning', "Cette ville n'existe pas dans la base de données.");
            return $this->redirectToRoute("villes");
        }

        $villeForm = $this->createForm(VilleType::class, $ville);
        
        $villeForm->handleRequest($request);
        if($villeForm->isSubmitted() && $villeForm->isValid()){
            try{
                $em->persist($ville);
                $em->flush();
                $this->addFlash("success", "La ville a été enregistrée.");
            }catch(\Exception $e){
                $this->addFlash('warning', "La ville n'a pas été modifiée, une erreur est arrivée.");
            }
            return $this->redirectToRoute("villes");
        }

        return $this->render('ville/insert.html.twig', [
            'villeForm' => $villeForm->createView(),
        ]);
    }

    /**
     * @Route("/villes/deletevilles/{id}", name="ville_delete", requirements={"id":"\d+"})
     */
    public function deleteVille($id, EntityManagerInterface $em)
    {
        $villesRepo = $this->getDoctrine()->getRepository(Ville::class);
        $ville = $villesRepo->find($id);

        if(empty($ville)){
            $this->addFlash('warning', "Cette ville n'existe pas dans la base de données.");
            return $this->redirectToRoute("villes");
        }

        try{
            $em->remove($ville);
            $em->flush();
            $this->addFlash('success', "La ville a été supprimée.");
        }catch(\Exception $e){
            $this->addFlash('warning', "La ville n'a pas été supprimée, regardez si elle est présente dans un lieu. Si c'est le cas, il n'est pas possible de la supprimer.");
        }

        return $this->redirectToRoute('villes');
    }
}
