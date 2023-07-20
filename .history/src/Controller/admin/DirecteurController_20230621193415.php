<?php

namespace App\Controller;

use App\Entity\Directeur;
use App\Form\DirecteurType;
use App\Security\UserAuthenticator;
use Symfony\Component\Form\FormError;
use App\Repository\DirecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Route('admin/directeur', name: 'admin_directeur_')]
class DirecteurController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('directeur/index.html.twig', [
            'controller_name' => 'DirecteurController',
        ]);
    }



    #[Route('/ajouter', name: 'ajout')]
    public function ajouter( Request $request,UserPasswordHasherInterface $userPasswordHasher,UserAuthenticator $authenticator,UserAuthenticatorInterface $userAuthenticator, DirecteurRepository $directeurRepository, EntityManagerInterface $entityManagerInterface,): Response
    {
       
        $directeur=new Directeur();
        $form =$this->createForm(DirecteurType::class , $directeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           
            $password = $form->get('plainPassword')->getData();
            $security = $form->get('security')->getData();

            if ($password !== $security) {
                $form->get('security')->addError(new FormError('Les champs "Mot de passe" et "Confirmation du mot de passe" doivent être identiques.'));
            }else{
            $directeur->setFonction('Directeur');

            $directeur->setPassword(
                $userPasswordHasher->hashPassword(
                    $directeur,
                    $form->get('plainPassword')->getData()
                    )
                );
            
            $directeur->setSecurity($security);
            $directeur->setRoles(['ROLE_DIRECTEUR']);
            $entityManagerInterface->persist($directeur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'Directeur a été ajouter avec succes');

            

           return $this->redirectToRoute('directeur_liste');
        }
        }
        return $this->renderForm('Directeur/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/liste', name: 'liste')]
    public function lister(DirecteurRepository $directeurRepository , Request $request): Response
    {
        $liste= $directeurRepository->findAll();
        return $this->render('Directeur/liste.html.twig', [
            'listes' =>$liste,
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifier(Directeur $directeur, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $form =$this->createForm(DirecteurType::class , $directeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

           
            $entityManagerInterface->persist($directeur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'Le directeur a été modifier avec succes');

           return $this->redirectToRoute('directeur_list');
        }
        return $this->renderForm('directeur/modifier.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer(Directeur $directeur,DirecteurRepository $directeurRepository): Response
    {
        $supprimer=$directeurRepository->remove($directeur, true);
        $this-> addFlash('success', 'L\'Directeur a été supprimer  avec succes');
        return $this->redirectToRoute('directeur_list');
    }
}
