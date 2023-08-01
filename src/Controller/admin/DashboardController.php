<?php

namespace App\Controller\admin;

use App\Entity\Classe;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use App\Repository\DirecteurRepository;
use App\Repository\EmployerRepository;
use App\Repository\ProffesseurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(EleveRepository $eleveRepository,ProffesseurRepository $proffesseurRepository,EmployerRepository $employerRepository,DirecteurRepository $directeurRepository): Response
    {
        $nombreTotalEleves = $eleveRepository->count([]);
        $nombreTotalDirecteur = $directeurRepository->count([]);
        $nombreTotalproffesseur = $proffesseurRepository->count([]);
        $nombreTotalEmployer = $employerRepository->count([]);
        return $this->render('admin/dashboard/index.html.twig', [

            'nombreProfesseur' => $nombreTotalproffesseur,
            'nombreEleves' => $nombreTotalEleves,
            'nombreEmployer' => $nombreTotalEmployer,
            'nombreDirecteur' => $nombreTotalDirecteur,
            
        ]);
    }
}
