<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionEleveController extends AbstractController
{
    #[Route('/inscription/eleve', name: 'app_inscription_eleve')]
    public function index(): Response
    {
        return $this->render('inscription_eleve/index.html.twig', [
            'controller_name' => 'InscriptionEleveController',
        ]);
    }
}
