<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProffesseurController extends AbstractController
{
    #[Route('/proffesseur', name: 'app_proffesseur')]
    public function index(): Response
    {
        return $this->render('proffesseur/index.html.twig', [
            'controller_name' => 'ProffesseurController',
        ]);
    }
}
