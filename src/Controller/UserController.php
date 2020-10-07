<?php

namespace App\Controller;

use App\Form\IdeaType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Participant;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="user_register")
     */
    public function register(EntityManagerInterface $em,Request $request,
        UserPasswordEncoderInterface $encoder)
    {
        $user = new Participant();
        $userForm = $this->createForm(RegisterType::class, $user);

        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid())
        {
            $mdpHashe = $encoder->encodePassword($user, $user->getMotDePasse());
            $user->setMotDePasse($mdpHashe);
            $user->setActif(1);
            $user->setAdministrateur(0);

            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Inscirption réussie");

            return $this->redirectToRoute("main");
        }

        return $this->render('user/register.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login()
    {
        return $this->render('user/login.html.twig', []);
    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logout()
    {
        //Il n'y a rien à faire
    }
}
