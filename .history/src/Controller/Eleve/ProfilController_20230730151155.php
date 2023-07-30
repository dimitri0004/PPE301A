<?php

namespace App\Controller;

use App\Entity\Eleve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eleve', name: 'eleve_')]
class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function profil(Eleve $eleve): Response
   
    {
        $eleve = $this->getUser();

        if (!$eleve instanceof \App\Entity\Eleve) {
            throw $this->createNotFoundException('Aucun élève connecté.');
        }

        return $this->render('eleve/profil.html.twig', [
            'eleve' => $eleve,
        ]);
    }
}
