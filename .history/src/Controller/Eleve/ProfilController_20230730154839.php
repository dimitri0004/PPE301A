<?php

namespace App\Controller\Eleve;

use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eleve', name: 'eleve_')]
class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(EleveRepository $eleveRepository): Response
   
    {
        
        $eleveId = $this->getUser();

        // Récupérer l'élève connecté à partir de son ID en utilisant le repository
        $eleve = $eleveRepository->find($eleveId);

        if (!$eleve) {
            throw $this->createNotFoundException('Élève introuvable.');
        }

        return $this->render('eleve/profil/index.html.twig', [
            'eleve' => $eleve,
        ]);
    }
}
