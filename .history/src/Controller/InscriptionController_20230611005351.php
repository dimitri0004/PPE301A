<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
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
            
            // Encodez le mot de passe
            $password = $passwordEncoder->hashPassword($user, $plainPassword);
            $user->setPassword($password);

            // Définir le rôle du professeur
            if ($request->$form->get('fonction')=="Directeur") {
                $user->setRoles(['ROLE_ADMIN']);
            } else if ($request->$user->get('fonction')=="Secretaire"){
                $user->setRoles(['ROLE_SECRETAIRE']);
            
            } else if ($request->$user->get('fonction')=="Comptable"){
                $user->setRoles(['ROLE_COMPTABLE']);
            
            } else if ($request->$user->get('fonction')=="Proffesseur"){
                $user->setRoles(['ROLE_PROFFESEUR']);
            } else if ($request->$user->get('fonction')=="Eleve"){
                $user->setRoles(['ROLE_ELEVE']);    
            }else{
                $user->setRoles(['ROLE_USER']);
            }

            $fonction = $user->getFonction();

            if ($fonction === 'Directeur') {
                $user->addRole('ROLE_ADMIN');
            }elseif ($fonction === 'Etudiant') {
                $user->addRole('ROLE_ETUDIANT');
            } elseif ($fonction === 'Professeur') {
                $user->addRole('ROLE_PROFESSEUR');
            } elseif ($fonction === 'Secretaire') {
                $user->addRole('ROLE_SECRETAIRE');
            }
        } elseif ($fonction === 'Comptable') {
            $user->addRole('ROLE_Comptable');
        }
               
            $user->setFonction($form->get('fonction')->getData());
            // Enregistrez l'utilisateur en base de données
            $entityManager->persist($user);
            $entityManager->flush();
        }
            // Redirigez l'utilisateur vers la page de connexion ou une autre page appropriée
           
        }
        return $this->renderForm('directeur/inscription/inscription.html.twig', [
            'registrationForm' => $form,
        ]);
    

   

        
}
}