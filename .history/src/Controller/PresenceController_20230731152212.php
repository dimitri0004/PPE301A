<?php

namespace App\Controller;

use App\Entity\Presence;
use App\Entity\Proffesseur;
use App\Form\PresenceType;
use App\Repository\PresenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[Route('/presence')]
class PresenceController extends AbstractController
{
    private $entityManager;

public function __construct(EntityManagerInterface $entityManager)
{
    $this->entityManager = $entityManager;
}
    #[Route('secretaire/presence', name: 'app_presence_index', methods: ['GET'])]
    public function index(PresenceRepository $presenceRepository): Response
    {
        $proffesseur = $this->entityManager->getRepository(Proffesseur::class)->findAll();

        return $this->render('secretaire/presence/index.html.twig', [
            'proffesseur' => $proffesseur,
        ]);
    }

    #[Route('secretaire/presence/new', name: 'app_presence_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $presence = new Presence();
        $form = $this->createForm(PresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($presence);
            $entityManager->flush();

            return $this->redirectToRoute('app_presence_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('secretaire/presence/new.html.twig', [
            'presence' => $presence,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presence_show', methods: ['GET'])]
    public function show(Presence $presence): Response
    {
        return $this->render('secretaire/presence/show.html.twig', [
            'presence' => $presence,
        ]);
    }

    #[Route('secretaire/presence/liste', name: 'app_presence_liste', methods: ['GET'])]
    public function liste(PresenceRepository $presenceRepository): Response
    {
        $presences = $presenceRepository->findBy(['present' => true]);

        return $this->render('secretaire/presence/liste.html.twig', [
            'presences' => $presences,
        ]);
    }

    #[Route('secretaire/presence/{id}/edit', name: 'app_presence_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Presence $presence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PresenceType::class, $presence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_presence_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('secretaire/presence/edit.html.twig', [
            'presence' => $presence,
            'form' => $form,
        ]);
    }

    #[Route('secretaire/presence/{id}', name: 'app_presence_delete', methods: ['POST'])]
    public function delete(Request $request, Presence $presence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $presence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($presence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_presence_liste', [], Response::HTTP_SEE_OTHER);
    }
}


  
