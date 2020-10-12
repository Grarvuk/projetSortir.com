<?php

namespace App\Controller;

use App\Form\IdeaType;
use App\Form\AdminRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Participant;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/register", name="user_register")
     */
    public function register(EntityManagerInterface $em,Request $request,
        UserPasswordEncoderInterface $encoder)
    {  
        $user = new Participant();
        $userForm = $this->createForm(AdminRegisterType::class, $user);

        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid())
        {
            $mdpHashe = $encoder->encodePassword($user, $user->getMotDePasse());
            $user->setMotDePasse($mdpHashe);

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
     * @Route("/admin/users", name="users")
     */
    public function listUser()
    {
        $userRepo = $this->getDoctrine()->getRepository(Participant::class);
        $users = $userRepo->findAll();

        return $this->render('admin/list.html.twig', compact("users"));
    }

    /**
     * @Route("/admin/updateuser/{id}", name="admin_user_update", requirements={"id":"\d+"})
     */
    public function updateUser($id, EntityManagerInterface $em,Request $request,
        UserPasswordEncoderInterface $encoder)
    {  
        $usersRepo = $this->getDoctrine()->getRepository(Participant::class);
        $user = $usersRepo->find($id);
        $userForm = $this->createForm(AdminRegisterType::class, $user);

        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid())
        {
            $mdpHashe = $encoder->encodePassword($user, $user->getMotDePasse());
            $user->setMotDePasse($mdpHashe);

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
     * @Route("/admin/deleteuser/{id}", name="user_delete", requirements={"id":"\d+"})
     */
    public function deleteUser($id, EntityManagerInterface $em)
    {
        $usersRepo = $this->getDoctrine()->getRepository(Participant::class);
        $user = $usersRepo->find($id);

        try{
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', "the user has been deleted");
        }catch(\Exception $e){
            $this->addFlash('warning', "Le participant n'a pas été supprimé, regardez si il est présent dans une sortie. Si c'est le cas, il n'est pas possible de le supprimer.");
        }

        return $this->redirectToRoute('users');
    }
}
