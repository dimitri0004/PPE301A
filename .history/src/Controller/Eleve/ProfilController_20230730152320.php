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
        $eleve = $this->getUser();

        $eleve= $eleveRepository->findBy(['user'=>$this->getUser()]);
       

        return $this->render('eleve/profil.html.twig', [
            'eleve' => $eleve,
        ]);
    }
}
