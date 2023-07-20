<?php

namespace App\Controller\admin;

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

#[Route('admin/proffesseur', name: 'admin_proffesseur_')]
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

            

           return $this->redirectToRoute('admin_proffesseur_liste');
        }
    }
    
        return $this->renderForm('admin/Proffesseur/ajouter.html.twig', [
            'form' => $form,
        ]);

        
    }

    
    #[Route('/liste', name: 'liste')]
    public function read(ProffesseurRepository $proffesseurRepository , Request $request): Response
    {
        $liste= $proffesseurRepository->findAll();
        $nombre =$proffesseurRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
        return $this->render('admin/Proffesseur/liste.html.twig', [
            'listes' =>$liste,
            'nombre' =>$nombre,
        ]);
    }
}
