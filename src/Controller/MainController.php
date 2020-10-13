<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="/")
     */
    public function index()
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
