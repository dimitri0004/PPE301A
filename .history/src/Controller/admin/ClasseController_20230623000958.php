<?php

namespace App\Controller\admin;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/classe', name: 'admin_classe_')]
class ClasseController extends AbstractController
{
    #[Route('/', name: 'liste', methods: ['GET'])]
    public function index(ClasseRepository $classeRepository): Response
    {
        return $this->render('admin/classe/index.html.twig', [
            'classes' => $classeRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'ajouter', methods: ['GET', 'POST'])]
    public function new(Request $request, ClasseRepository $classeRepository): Response
    {
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeRepository->save($classe, true);

            return $this->redirectToRoute('admin_classe_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/classe/new.html.twig', [
            'classe' => $classe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Classe $classe): Response
    {
        return $this->render('admin/classe/show.html.twig', [
            'classe' => $classe,
        ]);
    }

    #[Route('modifier/{id}', name: 'modifier', methods: ['GET', 'POST'])]
    public function edit(Request $request, Classe $classe, ClasseRepository $classeRepository): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $classeRepository->save($classe, true);

            return $this->redirectToRoute('admin_classe_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/classe/edit.html.twig', [
            'classe' => $classe,
            'form' => $form,
        ]);
    }

    #[Route('supprimer/{id}', name: 'supprimer', methods: ['POST'])]
    public function delete(Request $request, Classe $classe, ClasseRepository $classeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$classe->getId(), $request->request->get('_token'))) {
            $classeRepository->remove($classe, true);
        }

        return $this->redirectToRoute('admin_classe_liste', [], Response::HTTP_SEE_OTHER);
    }
}
