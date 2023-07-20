<?php

namespace App\Controller\Secretaire;

use App\Entity\Anne;
use App\Entity\Note;
use App\Entity\Classe;
use App\Form\NoteType;
use App\Repository\AnneRepository;
use App\Repository\NoteRepository;
use App\Repository\EleveRepository;
use App\Repository\ClasseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function new(Request $request, NoteRepository $noteRepository,ClasseRepository $classeRepository,AnneRepository $anneeRepository): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note, [
            'classes' => $classeRepository->findAll(),
            'annes' => $anneeRepository->findAll(),
        ]);
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

    #[Route('/recuperer', name: 'recupere', methods: ['POST'])]
    public function recupererEleves(Request $request, EleveRepository $eleveRepository): Response
    {
        $anneeId = $request->request->get('anne');
        $classeId = $request->request->get('classe');

        // Récupérer les élèves en fonction de l'année et de la classe sélectionnées
        $eleves = $eleveRepository->findBy(['classe'=>$classeId, 'anne'=>$anneeId]);

        // Générer le HTML des options des élèves
        $elevesOptions = [];
        foreach ($eleves as $eleve) {
            $elevesOptions[] = [
                'value' => $eleve->getId(),
                'text' => $eleve->getEmail(),
            ];
        }

    // Renvoyer la réponse JSON avec les options des élèves
    return new JsonResponse($elevesOptions);
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
            $datemiseajour=new \DateTime();
            $note->setDateMiseajour($datemiseajour);
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
