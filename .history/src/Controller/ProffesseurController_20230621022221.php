<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/proffesseur', name: 'proffesseur_')]
class ProffesseurController extends AbstractController
{


    #[Route('/ajouter', name: 'ajouter')]
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManagerInterface): Response
    {
        $proffesseur=new Proffesseur();
        $form =$this->createForm(ProffesseurType::class , $proffesseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $password = $form->get('plainPassword')->getData();
            $security = $form->get('security')->getData();

            if ($password !== $security) {
                $form->get('security')->addError(new FormError('password et confirme password sont pas identiques'));
            }else{

           $proffesseur->setPassword(
                $userPasswordHasher->hashPassword(
                    $proffesseur,
                    $form->get('plainPassword')->getData()
                    )
                );
            


           
                
                $proffesseur->setRoles(['ROLE_SECRETAIRE']);
                $proffesseur->setFonction('Proffesseur');
               
               
              
            $proffesseur->setSecurity($security);    
           
            $entityManagerInterface->persist($proffesseur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'Proffesseur a été ajouter avec succes');

            

           return $this->redirectToRoute('Proffesseur_liste');
        }
    }
    
        return $this->renderForm('Proffesseur/ajouter.html.twig', [
            'form' => $form,
        ]);

        
    }

    
    #[Route('/proffesseur', name: 'app_proffesseur')]
    public function index(): Response
    {
        return $this->render('proffesseur/index.html.twig', [
            'controller_name' => 'ProffesseurController',
        ]);
    }
}
