<?php

namespace App\Controller\Secretaire;

use App\Entity\Classe;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use App\Repository\EmployerRepository;
use App\Repository\ProffesseurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(EleveRepository $eleveRepository,ProffesseurRepository $proffesseurRepository,EmployerRepository $employerRepository): Response
    {
        $nombreTotalEleves = $eleveRepository->count([]);
        $nombreTotalproffesseur = $proffesseurRepository->count([]);
        $nombreTotalEmployer = $employerRepository->count([]);
        return $this->render('admin/dashboard/index.html.twig', [

            'nombreProfesseur' => $nombreTotalproffesseur,
            'nombreEleves' => $nombreTotalEleves,
            'nombreEmployer' => $nombreTotalEmployer,
            
        ]);
    }
}
