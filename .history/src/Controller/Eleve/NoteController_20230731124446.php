<?php

namespace App\Controller\Eleve;

use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eleve', name: 'eleve_note_')]
class NoteController extends AbstractController
{
    #[Route('/note', name: 'Afficher')]
    public function index(NoteRepository $noteRepository): Response
    {
        $liste= $noteRepository->findBy(['id'=>$this->getUser()]);
        return $this->render('eleve/note/index.html.twig', [
            'notes' => $liste,
        ]);
    }
}
