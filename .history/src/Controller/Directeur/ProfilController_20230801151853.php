<?php

namespace App\Controller\Secretaire;


use App\Repository\EmployerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/secretaire',name: 'secretaire_')]
class ProfilController extends AbstractController
{
    
    #[Route('/profil', name: 'profil')]
    public function profil(EmployerRepository $employerRepository): Response
   
    {
        
        $employerId = $this->getUser();

        // Récupérer l'élève connecté à partir de son ID en utilisant le repository
        $secretaire = $employerRepository->find($employerId);

        if (!$secretaire) {
            throw $this->createNotFoundException('Secretaire introuvable.');
        }

        return $this->render('secretaire/profil/index.html.twig', [
            'secretaire' => $secretaire,
        ]);
    }

}
