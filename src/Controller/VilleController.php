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
            $em->persist($ville);
            $em->flush();

            $this->addFlash("success", "ville enregistré");
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
            throw $this->createNotFoundException("This ville do not exists !");
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
        $villeForm = $this->createForm(VilleType::class, $ville);
        
        $villeForm->handleRequest($request);
        if($villeForm->isSubmitted() && $villeForm->isValid()){
            $em->persist($ville);
            $em->flush();

            $this->addFlash("success", "ville enregistré");
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

        try{
            $em->remove($ville);
            $em->flush();
            $this->addFlash('success', "the ville has been deleted");
        }catch(\Exception $e){
            $this->addFlash('warning', "Le ville n'a pas été supprimée, regardez si elle est présente dans un lieu. Si c'est le cas, il n'est pas possible de la supprimer.");
        }

        return $this->redirectToRoute('villes');
    }
}
