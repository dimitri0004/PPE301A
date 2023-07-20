<?php

namespace App\Controller\admin;

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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('admin/employer', name: 'admin_employer_')]

class EmployerController extends AbstractController
{
    #[Route('/ajouter', name: 'ajouter')]
    public function add(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManagerInterface): Response
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
              
            $employer->setSecurity($security);    
            $employer->setFonction($form->get('fonction')->getData());
            $entityManagerInterface->persist($employer);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'employer a été ajouter avec succes');

            

           return $this->redirectToRoute('admin_employer_liste');
        }
    }
    
        return $this->renderForm('admin/employer/ajouter.html.twig', [
            'form' => $form,
        ]);

        
    }

    #[Route('/liste', name: 'liste')]
    public function read(EmployerRepository $employerRepository , Request $request): Response
    {

       
        $liste= $employerRepository->findAll();
        $nombre= $employerRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('admin/employer/liste.html.twig', [
            'listes' =>$liste,
            'nombre' =>$nombre,
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function update($id, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $employer= $entityManagerInterface->getRepository(Employer::class)->find($id);
        $form =$this->createForm(EmployerType::class , $employer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            
            $entityManagerInterface->persist($employer);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'Le directeur a été modifier avec succes');

           return $this->redirectToRoute('admin_directeur_liste');
        }
        return $this->renderForm('admin/employer/modifier.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function delete($id,EmployerRepository $employerRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $employer= $entityManagerInterface->getRepository(Employer::class)->find($id);
        $supprimer=$employerRepository->remove($employer, true);
        $this-> addFlash('success', 'L\'Employer a été supprimer  avec succes');
        return $this->redirectToRoute('admin_employer_liste');
    }
}
