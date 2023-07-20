<?php

namespace App\Controller;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteController extends AbstractController
{
    #[Route('/', name: 'liste', methods: ['GET'])]
    public function index(NoteRepository $NoteRepository): Response
    {
        return $this->render('secretaire/note/liste.html.twig', [
            'notes' => $NoteRepository->findAll(),
        ]);
    }



    #[Route('/ajouter', name: 'ajouter', methods: ['GET', 'POST'])]
    public function new(Request $request, NoteRepository $NoteRepository): Response
    {
        $Note = new Note();
        $form = $this->createForm(NoteType::class, $Note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $NoteRepository->save($Note, true);

            return $this->redirectToRoute('secretaire_note_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('secretaire/note/ajouter.html.twig', [
            'note' => $Note,
            'form' => $form,
        ]);
    }







    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Note $Note): Response
    {
        return $this->render('secretaire/note/show.html.twig', [
            'note' => $Note,
        ]);
    }





    #[Route('modifier/{id}', name: 'modifier', methods: ['GET', 'POST'])]
    public function edit(Request $request, Note $Note, NoteRepository $NoteRepository): Response
    {
        $form = $this->createForm(NoteType::class, $Note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $NoteRepository->save($Note, true);

            return $this->redirectToRoute('secretaire_note_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('secretaire/note/modifier.html.twig', [
            'note' => $Note,
            'form' => $form,
        ]);
    }

    #[Route('supprimer/{id}', name: 'supprimer', methods: ['POST'])]
    public function delete(Request $request, Note $Note, NoteRepository $NoteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$Note->getId(), $request->request->get('_token'))) {
            $NoteRepository->remove($Note, true);
        }

        return $this->redirectToRoute('secretaire_note_liste', [], Response::HTTP_SEE_OTHER);
    }
}
