<?php

namespace App\Controller;

use App\Entity\Employer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

#[Route('/employer', name: 'employer_')]
class EmployerController extends AbstractController
{
    #[Route('/ajouter', name: 'ajout')]
    public function add(Request $request, UserPasswordHasher $userPasswordHasher, EntityManagerInterface $entityManagerInterface): Response
    {
        $employer=new Employer();
        $form =$this->createForm(EmployerType::class , $employer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           

           

            $employer->setPassword(
                $userPasswordHasher->hashPassword(
                    $employer,
                    $form->get('plainPassword')->getData()
                    )
                );
            
            
            $employer->setRoles(['ROLE_employer']);
            $entityManagerInterface->persist($employer);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'employer a été ajouter avec succes');

            

           return $this->redirectToRoute('employer_liste');
        }
        return $this->renderForm('employer/index.html.twig', [
            'form' => $form,
        ]);

        
    }

    #[Route('/ajouter', name: 'ajout')]
    public function index(): Response
    {

        
        return $this->render('employer/index.html.twig', [
            'controller_name' => 'EmployerController',
        ]);
    }
}
