<?php

namespace App\Controller;

use App\Entity\Directeur;
use App\Form\DirecteurType;
use App\Repository\DirecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/directeur', name: 'directeur_')]
class DirecteurController extends AbstractController
{
    #[Route('/', name: 'app_directeur')]
    public function index(): Response
    {
        return $this->render('directeur/index.html.twig', [
            'controller_name' => 'DirecteurController',
        ]);
    }



    #[Route('/ajouter', name: 'ajout')]
    public function ajouter( Request $request, DirecteurRepository $directeurRepository, EntityManagerInterface $entityManagerInterface): Response
    {
       
        $directeur=new Directeur();
        $form =$this->createForm(DirecteurType::class , $directeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user=$this->getUser();
            $directeur->setUser($user);
            $entityManagerInterface->persist($directeur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'Directeur a été ajouter avec succes');

           return $this->redirectToRoute('directeur_list');
        }
        return $this->renderForm('Directeur/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/lister', name: 'list')]
    public function lister(DirecteurRepository $directeurRepository , Request $request): Response
    {
        $liste= $directeurRepository->findAll();
        return $this->render('Directeur/liste.html.twig', [
            'liste' =>$liste,
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifier(Directeur $directeur, Request $request, EntityManagerInterface $entityManagerInterface,$id): Response
    {
        $form =$this->createForm(DirecteurType::class , $directeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $user=$this->getUser();
            $directeur->setUser($user);
            $entityManagerInterface->persist($directeur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'Directeur a été modifier avec succes');

           return $this->redirectToRoute('Directeur_list');
        }
        return $this->renderForm('directeur/modifier.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer(Directeur $directeur,DirecteurRepository $directeurRepository,$id): Response
    {
        $supprimer=$directeurRepository->remove($directeur, true);
        $this-> addFlash('success', 'L\'Directeur a été supprimer  avec succes');
        return $this->redirectToRoute('Directeur_list');
    }
}
