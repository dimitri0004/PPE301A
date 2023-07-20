<?php

namespace App\Controller;

use App\Entity\Employer;
use App\Form\EmployerType;
use Symfony\Component\Form\FormError;
use App\Repository\EmployerRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

            $password = $form->get('plainPassword')->getData();
            $security = $form->get('security')->getData();

            if ($password !== $security) {
                $form->get('security')->addError(new FormError('password et confirme password sont pas identiques'));
            }else{

           $employer->setPassword(
                $userPasswordHasher->hashPassword(
                    $employer,
                    $form->get('plainPassword')->getData()
                    )
                );
            
                $fonction = $employer->getFonction();

           
                if ($fonction === 'Secretaire') {
                    $employer->setRoles(['ROLE_SECRETAIRE']);
                } elseif ($fonction === 'Comptable') {
                    $employer->setRoles(['ROLE_COMPTABLE']);
                } else{
                    $employer->setRoles(['ROLE_USER']);
                }
                   
            $employer->setFonction($form->get('fonction')->getData());
            $entityManagerInterface->persist($employer);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'employer a été ajouter avec succes');

            

           #return $this->redirectToRoute('employer_liste');
        }
    }
    
        return $this->renderForm('employer/ajouter.html.twig', [
            'form' => $form,
        ]);

        
    }

    #[Route('/liste', name: 'liste')]
    public function read(EmployerRepository $directeurRepository , Request $request): Response
    {
        $liste= $directeurRepository->findAll();
        return $this->render('Employer/liste.html.twig', [
            'listes' =>$liste,
        ]);
    }

    #[Route('/modifier', name: 'modifier')]
    public function update(): Response
    {

        
        return $this->render('employer/index.html.twig', [
            'controller_name' => 'EmployerController',
        ]);
    }
}
