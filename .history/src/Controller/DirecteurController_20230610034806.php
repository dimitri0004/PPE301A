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
    public function ajouter( Request $request, DirecteurRepository $DirecteurRepository, EntityManagerInterface $entityManagerInterface): Response
    {
       
        $Directeur=new Directeur();
        $form =$this->createForm(DirecteurType::class , $Directeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user=$this->getUser();
            $Directeur->setUser($user);
            $entityManagerInterface->persist($Directeur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'Directeur a été ajouter avec succes');

           return $this->redirectToRoute('directeur_list');
        }
        return $this->renderForm('Directeur/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/lister', name: 'list')]
    public function lister(DirecteurRepository $DirecteurRepository , Request $request): Response
    {
        $liste= $DirecteurRepository->findAll();
        return $this->render('Directeur/liste.html.twig', [
            'liste' =>$liste,
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifier(Directeur $Directeur, Request $request, EntityManagerInterface $entityManagerInterface,$id): Response
    {
        $form =$this->createForm(DirecteurType::class , $Directeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $entityManagerInterface->persist($Directeur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'Directeur a été modifier avec succes');

           return $this->redirectToRoute('Directeur_list');
        }
        return $this->renderForm('Directeur/modifier.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer(Directeur $Directeur,DirecteurRepository $DirecteurRepository,$id): Response
    {
        $supprimer=$DirecteurRepository->remove($Directeur, true);
        $this-> addFlash('success', 'L\'Directeur a été supprimer  avec succes');
        return $this->redirectToRoute('Directeur_list');
    }
}
