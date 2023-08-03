<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_log')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_directeur_liste'); // Rediriger vers une autre page
        } else {
            // Récupérer l'erreur de connexion s'il y en a une
            $error = $authenticationUtils->getLastAuthenticationError();
            // Dernier nom d'utilisateur saisi par l'utilisateur
            $lastUsername = $authenticationUtils->getLastUsername();
            
            
            // Récupérer l'utilisateur connecté
            
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/', name: 'app_login')]
    public function loginEleve(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('eleve_dashboard'); // Rediriger vers une autre page
        } else {
            // Récupérer l'erreur de connexion s'il y en a une
            $error = $authenticationUtils->getLastAuthenticationError();
            // Dernier nom d'utilisateur saisi par l'utilisateur
            $lastUsername = $authenticationUtils->getLastUsername();
            
            
            // Récupérer l'utilisateur connecté
            
        }

        return $this->render('security/loginEleve.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
