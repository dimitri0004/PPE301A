<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/employer', name: 'employer_')]
class EmployerController extends AbstractController
{
    #[Route('/ajouter', name: 'ajout')]
    public function index(): Response
    {
        return $this->render('employer/index.html.twig', [
            'controller_name' => 'EmployerController',
        ]);
    }
}
