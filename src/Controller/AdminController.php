<?php

namespace App\Controller;

use App\Form\IdeaType;
use App\Form\AdminRegisterType;
use App\Form\AdminUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Participant;
use App\Entity\Campus;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Finder\Finder;

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

            return $this->redirectToRoute("users");
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
        $userForm = $this->createForm(AdminUpdateType::class, $user);

        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid())
        {
            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Inscirption réussie");

            return $this->redirectToRoute("users");
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

    /**
     * @Route("/admin/integrationuser", name="user_integration")
     */
    public function integrationUser(EntityManagerInterface $em,Request $request,
        UserPasswordEncoderInterface $encoder)
    {  
        $finder = new Finder();
        $finder->files()->in('csv')->name('*.csv');

        if ($finder->hasResults()) {
            foreach ($finder as $file) {
                $handle = fopen($file->getRealPath(), "r");
                $lineNumber = 1;

                while (($raw_string = fgets($handle)) !== false) {
                    $row = str_getcsv($raw_string);
                    
                    $user = new Participant();

                    $campusRepo = $this->getDoctrine()->getRepository(Campus::class);
                    $campus = $campusRepo->find($row[0]);

                    $user->setCampus($campus);
                    $user->setPseudo($row[1]);
                    $user->setPrenom($row[2]);
                    $user->setNom($row[3]);
                    $user->setTelephone($row[4]);
                    $user->setMail($row[5]);
                    $user->setAdministrateur($row[7]);
                    $user->setActif($row[8]);

                    $mdpHashe = $encoder->encodePassword($user, $row[6]);
                    $user->setMotDePasse($mdpHashe);

                    $em->persist($user);
                    $em->flush();

                    $lineNumber++;
                }

                fclose($handle);
                unlink($file->getRealPath());
            }
            $this->addFlash("success", "Intégration réussie");
        }else{
            $this->addFlash("warning", "Il n'y a pas de fichier csv dans public/csv/");
        }
        

        
        return $this->redirectToRoute("users");
    }
}
