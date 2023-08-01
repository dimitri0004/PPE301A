<?php

namespace App\Controller\Eleve;

use App\Entity\Eleve;
use App\Repository\NoteRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/eleve', name: 'eleve_note_')]
class NoteController extends AbstractController
{
    #[Route('/note', name: 'Afficher')]
    public function index(NoteRepository $noteRepository, Security $security): Response
{
    // Récupérer l'utilisateur connecté (élève)
    $eleve = $security->getUser();

    // Vérifier si l'utilisateur est bien un élève
    if (!$eleve instanceof Eleve) {
        throw $this->createNotFoundException('Utilisateur invalide.');
    }

    // Récupérer la liste des notes associées à l'élève
    $liste = $noteRepository->findBy(['eleve' => $eleve]);

    return $this->render('eleve/note/index.html.twig', [
        'notes' => $liste,
    ]);
}





}
