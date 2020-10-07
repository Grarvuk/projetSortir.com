<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/ModifierParticipant", name="ModifierParticipant")
     */
    public function modifierParticipant(Request $request)
    {
        $participantRepo = $this->getDoctrine()->getRepository(Participant::class);
        
        $participant = $this.getUser();

        $participantForm = $this->createForm(ParticipantType::class, $participant);

        $participantForm->handleRequest($request);
        if($participantForm->isSubmitted() && $participantForm->isValid()){
            $em->persist($participant);
            $em->flush();
            $this->addFlash("success", "Votre profil a bien été modifié.");
            return $this->redirectToRoute("index");
        }

        return $this->render('user/modifier.html.twig', [
            'participant' => $participant,
            "participantForm" => $participantForm->createView(),
        ]);
    }
}
