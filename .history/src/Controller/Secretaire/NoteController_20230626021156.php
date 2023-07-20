<?php

namespace App\Controller\Secretaire;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\NoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('secretaire/note', name: 'secretaire_note_')]
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
    public function new(Request $request, NoteRepository $noteRepository): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la note de l'élève
            $valeurNote = $note->getNote();

            // Appeler la fonction gestionMention pour obtenir la mention correspondante
            $mention = $this->gestionMention($valeurNote);

            // Définir la mention dans l'entité Note
            $note->setMention($mention);

            // Enregistrer la note dans la base de données
            $noteRepository->save($note, true);

            return $this->redirectToRoute('secretaire_note_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('secretaire/note/ajouter.html.twig', [
            'note' => $note,
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
    public function edit(Note $note,Request $request, Note $Note, NoteRepository $noteRepository): Response
    {
        
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer la note de l'élève
            $valeurNote = $note->getNote();

            // Appeler la fonction gestionMention pour obtenir la mention correspondante
            $mention = $this->gestionMention($valeurNote);

            // Définir la mention dans l'entité Note
            $note->setMention($mention);

            // Enregistrer la note dans la base de données
            $datemisajour=new \DateTime();
            $noteRepository->setDateMiseaJour($datemisajour);
            $noteRepository->save($note, true);

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




    private function gestionMention($note)
    {
        // Définir les plages de notes pour chaque mention
        $plageInsuffisant = [0, 9];
        $plagePassable = [10, 11];
        $plageAssezBien = [12, 13];
        $plageBien = [14, 15];
        $plageTresBien = [16, 18];
        $plageExellent = [19, 20];

        // Vérifier dans quelle plage se trouve la note et définir la mention correspondante
        $mention = '';

        if ($note >= $plageInsuffisant[0] && $note <= $plageInsuffisant[1]) {
            $mention = 'INSSUFISANT';
        } elseif ($note >= $plagePassable[0] && $note <= $plagePassable[1]) {
            $mention = 'PASSABLE';
        
        } elseif ($note >= $plageAssezBien[0] && $note <= $plageAssezBien[1]) {
            $mention = 'ASSEZ-BIEN';
        
        } elseif ($note >= $plageBien[0] && $note <= $plageBien[1]) {
            $mention = 'BIEN';
        
        } elseif ($note >= $plageTresBien[0] && $note <= $plageTresBien[1]) {
            $mention = 'TRES-BIEN';
        
        } elseif ($note >=  $plageExellent[0] && $note <=  $plageExellent[1]) {
            $mention = 'EXCELLENT';
        }



        return $mention;
    }


}
