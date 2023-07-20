<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\UserAuthenticator;

class AdminController extends AbstractController
{
    #[Route('/admin/register', name: 'app_admin')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticator $authenticator,UserAuthenticatorInterface $userAuthenticator, EntityManagerInterface $entityManager): Response
    {

        
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('plainPassword')->getData() !== $form->get('confirmPassword')->getData()) {
                $form->get('confirmPassword')->addError(new FormError('Les mots de passe ne correspondent pas.'));
            } else {
            
            $admin->setFonction('Admin');
            $admin->setPassword(
                $userPasswordHasher->hashPassword(
                    $admin,
                    $form->get('plainPassword')->getData()
                    )
                );
            $admin->setRoles(['ROLE_ADMIN']);
            $entityManager->persist($admin);
            $entityManager->flush();

            // Rediriger ou afficher un message de succès
            return $userAuthenticator->authenticateUser(
                $admin,
                $authenticator,
                $request
            );
        }
    }


        return $this->render('admin/admin.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


}
