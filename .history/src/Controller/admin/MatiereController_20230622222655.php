<?php

namespace App\Controller\admin;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/matiere', name: 'admin_matiere_')]
class MatiereController extends AbstractController
{
    #[Route('/', name: 'liste', methods: ['GET'])]
    public function index(MatiereRepository $matiereRepository): Response
    {
        return $this->render('admin/matiere/index.html.twig', [
            'matieres' => $matiereRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'ajouter', methods: ['GET', 'POST'])]
    public function new(Request $request, MatiereRepository $matiereRepository): Response
    {
        $matiere = new Matiere();
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $matiereRepository->save($matiere, true);

            return $this->redirectToRoute('admin_matiere_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/matiere/new.html.twig', [
            'matiere' => $matiere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Matiere $matiere): Response
    {
        return $this->render('admin/matiere/show.html.twig', [
            'matiere' => $matiere,
        ]);
    }

    #[Route('modifier/{id}', name: 'modifier', methods: ['GET', 'POST'])]
    public function edit(Request $request, Matiere $matiere, MatiereRepository $matiereRepository): Response
    {
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $matiereRepository->save($matiere, true);

            return $this->redirectToRoute('admin_matiere_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/matiere/edit.html.twig', [
            'matiere' => $matiere,
            'form' => $form,
        ]);
    }

    #[Route('supprimer/{id}', name: 'supprimer', methods: ['POST'])]
    public function delete(Request $request, Matiere $matiere, MatiereRepository $matiereRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$matiere->getId(), $request->request->get('_token'))) {
            $matiereRepository->remove($matiere, true);
        }

        return $this->redirectToRoute('admin_matiere_liste', [], Response::HTTP_SEE_OTHER);
    }
}
