<?php

namespace App\Controller;

use App\Entity\Anne;
use App\Form\AnneType;
use App\Repository\AnneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/anne',name: 'secretaire_anne_')]
class AnneController extends AbstractController
{
    #[Route('/', name: 'liste', methods: ['GET'])]
    public function index(AnneRepository $anneRepository): Response
    {
        return $this->render('secretaire/anne/index.html.twig', [
            'annes' => $anneRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'ajouter', methods: ['GET', 'POST'])]
    public function new(Request $request, AnneRepository $anneRepository): Response
    {
        $anne = new Anne();
        $form = $this->createForm(AnneType::class, $anne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $anneRepository->save($anne, true);

            return $this->redirectToRoute('secretaire_anne_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('secretaire/anne/new.html.twig', [
            'anne' => $anne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Anne $anne): Response
    {
        return $this->render('secretaire/anne/show.html.twig', [
            'anne' => $anne,
        ]);
    }

    #[Route('modifier/{id}', name: 'modifier', methods: ['GET', 'POST'])]
    public function edit(Request $request, Anne $anne, AnneRepository $anneRepository): Response
    {
        $form = $this->createForm(AnneType::class, $anne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $anneRepository->save($anne, true);

            return $this->redirectToRoute('secretaire_anne_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('anne/edit.html.twig', [
            'anne' => $anne,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_anne_delete', methods: ['POST'])]
    public function delete(Request $request, Anne $anne, AnneRepository $anneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$anne->getId(), $request->request->get('_token'))) {
            $anneRepository->remove($anne, true);
        }

        return $this->redirectToRoute('app_anne_index', [], Response::HTTP_SEE_OTHER);
    }
}
