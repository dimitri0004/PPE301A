<?php

namespace App\Controller\Secretaire;

use App\Entity\Classe;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/secretaire', name: 'secretaire_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(EleveRepository $eleveRepository): Response
    {
        $nombreTotalEleves = $eleveRepository->count([]);
        return $this->render('secretaire/dashboard/index.html.twig', [
            
            'nombreEleves' => $nombreTotalEleves
            
        ]);
    }
}
