<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/inscription', name: 'inscription')]
class InscriptionController extends AbstractController
{
    #[Route('/ajouter', name: '')]
    public function index(Request $request ,UserPasswordHasherInterface $passwordEncoder,UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // ...

    if ($form->isSubmitted() && $form->isValid()) {
        if ($form->get('plainPassword')->getData() !== $form->get('confirmPassword')->getData()) {
            $form->get('confirmPassword')->addError(new FormError('Les mots de passe ne correspondent pas.'));
        } else {
           
            $user = $form->getData();
            $plainPassword = $form->get('plainPassword')->getData();
            
           
            $user->setPassword($plainPassword);

            // Définir le rôle du professeur
           

            $fonction = $user->getFonction();

            if ($fonction === 'Directeur') {
                $user->setRoles(['ROLE_ADMIN']);
            }elseif ($fonction === 'Eleve') {
                $user->setRoles(['ROLE_ELEVE']); 
            } elseif ($fonction === 'Professeur') {
                $user->setRoles(['ROLE_PROFFESEUR']);
            } elseif ($fonction === 'Secretaire') {
                $user->setRoles(['ROLE_SECRETAIRE']);
            } elseif ($fonction === 'Comptable') {
                $user->setRoles(['ROLE_COMPTABLE']);
            }else{
                $user->setRoles(['ROLE_USER']);
            }
               
            $user->setFonction($form->get('fonction')->getData());
            // Enregistrez l'utilisateur en base de données
            $entityManager->persist($user);
            $entityManager->flush();
        }
            // Redirigez l'utilisateur vers la page de connexion ou une autre page appropriée
            return $this->redirectToRoute('inscription');

           
        }
        return $this->renderForm('directeur/inscription/inscription.html.twig', [
            'registrationForm' => $form,
        ]);
    
    }   
    #[Route('', name: 'liste')]
    public function liste(UserRepository $usersRepository): Response
        {
            $users= $usersRepository->findBy([],[]);
            return $this->render('directeur/inscription.html.twig', compact('inscription') 
            );
        }
                
   

        
}
