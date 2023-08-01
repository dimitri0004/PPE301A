<?php

namespace App\Controller\Eleve;

use App\Entity\Classe;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use App\Repository\DirecteurRepository;
use App\Repository\EmployerRepository;
use App\Repository\MatiereRepository;
use App\Repository\NoteRepository;
use App\Repository\ProffesseurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/eleve', name: 'eleve_')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(MatiereRepository $matiereRepository, NoteRepository $noteRepository,): Response
    {
        $nombreTotalmatiere = $matiereRepository->count([]);
        $nombreTotalnote = $noteRepository->count([]);
        #$nombreTotalproffesseur = $proffesseurRepository->count([]);
        #$nombreTotalEmployer = $employerRepository->count([]);
        return $this->render('eleve/dashboard/index.html.twig', [

            'nombrematiere' => $nombreTotalmatiere,
            'nombrenote' => $nombreTotalnote,
           #'nombreEmployer' => $nombreTotalEmployer,
            #'nombreDirecteur' => $nombreTotalDirecteur,
            
        ]);
    }
}
