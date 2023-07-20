<?php

namespace App\Controller;

use App\Entity\User;
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
        $form = $this->createForm(RegistrationType::class, $user);
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
            $user->setRoles(['ROLE_PROFESSEUR']);

            // Enregistrez l'utilisateur en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirigez l'utilisateur vers la page de connexion ou une autre page appropriée
            return $this->redirectToRoute('app_login');
        }
    }

    // ...

        }
}
