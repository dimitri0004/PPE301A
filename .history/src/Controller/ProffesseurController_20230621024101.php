<?php

namespace App\Controller;

use App\Entity\Proffesseur;
use App\Form\ProffesseurType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProffesseurRepository;
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
               
                $proffesseur->setRoles(['ROLE_PROFESSEUR']);
                $proffesseur->setFonction('Proffesseur');
               
               
              
            $proffesseur->setSecurity($security);    
           
            $entityManagerInterface->persist($proffesseur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'Le Professeur a été ajouter avec succes');

            

           return $this->redirectToRoute('proffesseur_liste');
        }
    }
    
        return $this->renderForm('Proffesseur/ajouter.html.twig', [
            'form' => $form,
        ]);

        
    }

    
    #[Route('/liste', name: 'liste')]
    public function read(ProffesseurRepository $proffesseurRepository , Request $request): Response
    {
        $liste= $proffesseurRepository->findAll();
        return $this->render('Employer/liste.html.twig', [
            'listes' =>$liste,
        ]);
    }
}
