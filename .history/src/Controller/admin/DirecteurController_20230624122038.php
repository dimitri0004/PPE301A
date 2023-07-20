<?php

namespace App\Controller\admin;

use App\Entity\Directeur;
use App\Form\DirecteurType;
use App\Security\UserAuthenticator;
use Symfony\Component\Form\FormError;
use App\Repository\DirecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('admin/directeur', name: 'admin_directeur_')]

class DirecteurController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/directeur/index.html.twig', [
            'controller_name' => 'DirecteurController',
        ]);
    }



    #[Route('/ajouter', name: 'ajouter')]
    public function add( Request $request,UserPasswordHasherInterface $userPasswordHasher,UserAuthenticator $authenticator,UserAuthenticatorInterface $userAuthenticator, DirecteurRepository $directeurRepository, EntityManagerInterface $entityManagerInterface,): Response
    {
       
        $directeur=new Directeur();
        $form =$this->createForm(DirecteurType::class , $directeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           
            $password = $form->get('plainPassword')->getData();
            $security = $form->get('security')->getData();

            if ($password !== $security) {
                $form->get('security')->addError(new FormError('Les champs "Mot de passe" et "Confirmation du mot de passe" doivent être identiques.'));
            }else{
            $directeur->setFonction('Directeur');

            $directeur->setPassword(
                $userPasswordHasher->hashPassword(
                    $directeur,
                    $form->get('plainPassword')->getData()
                    )
                );
            
            $directeur->setSecurity($security);
            $directeur->setRoles(['ROLE_DIRECTEUR']);
            $entityManagerInterface->persist($directeur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'Directeur a été ajouter avec succes');

            

           return $this->redirectToRoute('admin_directeur_liste');
        }
        }
        return $this->renderForm('admin/Directeur/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/liste', name: 'liste')]
    public function read(DirecteurRepository $directeurRepository , Request $request): Response
    {
       
        $liste= $directeurRepository->findAll();
        $nombre = $directeurRepository->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();
        return $this->render('admin/Directeur/liste.html.twig', [
            'listes' =>$liste,
            'nombre' =>$nombre

        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function update($id, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $directeur= $entityManagerInterface->getRepository(Directeur::class)->find($id);
        $form =$this->createForm(DirecteurType::class , $directeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            
            $entityManagerInterface->persist($directeur);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'Le directeur a été modifier avec succes');

           return $this->redirectToRoute('admin_directeur_liste');
        }
        return $this->render('admin/directeur/modifier.html.twig', [
            'form' => $form->createView(),
            'id'=>$id,
        ]);
    }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function delete($id,DirecteurRepository $directeurRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        $directeur= $entityManagerInterface->getRepository(Directeur::class)->find($id);
        $supprimer=$directeurRepository->remove($directeur, true);
        $this-> addFlash('success', 'Le Directeur a été supprimer  avec succes');
        return $this->redirectToRoute('admin_directeur_liste');
    }
}
