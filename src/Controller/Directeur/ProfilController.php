<?php

namespace App\Controller\Directeur;


use App\Repository\EmployerRepository;
use App\Repository\DirecteurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/directeur',name: 'directeur_')]
class ProfilController extends AbstractController
{
    
    #[Route('/profil', name: 'profil')]
    public function profil(DirecteurRepository $directeurRepository): Response
   
    {
        
        $employerId = $this->getUser();

        // Récupérer l'élève connecté à partir de son ID en utilisant le repository
        $secretaire = $directeurRepository->find($employerId);

        if (!$secretaire) {
            throw $this->createNotFoundException('directeur introuvable.');
        }

        return $this->render('directeur/profil/index.html.twig', [
            'secretaire' => $secretaire,
        ]);
    }

}
