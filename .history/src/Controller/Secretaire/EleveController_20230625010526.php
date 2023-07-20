<?php

namespace App\Controller\Secretaire;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('secretaire/eleve' , name: 'secretaire_eleve_liste')]
class EleveController extends AbstractController
{
    #[Route('/', name: 'liste', methods: ['GET'])]
    public function index(EleveRepository $eleveRepository): Response
    {
        return $this->render('secretaire/eleve/index.html.twig', [
            'eleves' => $eleveRepository->findAll(),
        ]);
    }

    #[Route('/ajouter', name: 'ajouter')]
    public function add( Request $request,UserPasswordHasherInterface $userPasswordHasher, EleveRepository $EleveRepository, EntityManagerInterface $entityManagerInterface,): Response
    {
       
        $Eleve=new Eleve();
        $form =$this->createForm(EleveType::class , $Eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           
            $password = $form->get('plainPassword')->getData();
            $security = $form->get('security')->getData();

            if ($password !== $security) {
                $form->get('security')->addError(new FormError('Les champs "Mot de passe" et "Confirmation du mot de passe" doivent être identiques.'));
            }else{
            $Eleve->setFonction('Eleve');

            $Eleve->setPassword(
                $userPasswordHasher->hashPassword(
                    $Eleve,
                    $form->get('plainPassword')->getData()
                    )
                );
            
            $Eleve->setSecurity($security);
            $Eleve->setRoles(['ROLE_ELEVE']);
            $entityManagerInterface->persist($Eleve);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'L\'Eleve a été ajouter avec succes');

            

           return $this->redirectToRoute('secretaire_eleve_liste');
        }
        }
        return $this->renderForm('secretaire/eleve/ajouter.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function update($id, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $Eleve= $entityManagerInterface->getRepository(Eleve::class)->find($id);
        $form =$this->createForm(EleveType::class , $Eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            
            $entityManagerInterface->persist($Eleve);
            $entityManagerInterface->flush();
            $this-> addFlash('success', 'l\'Eleve a été modifier avec succes');

           return $this->redirectToRoute('secretaire_eleve_liste');
        }
        return $this->render('secretaire/eleve/modifier.html.twig', [
            'form' => $form->createView(),
           
        ]);
    }

    #[Route('supprimer/{id}', name: 'supprimer', methods: ['POST'])]
    public function delete(Request $request, Eleve $eleve, EleveRepository $eleveRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eleve->getId(), $request->request->get('_token'))) {
            $eleveRepository->remove($eleve, true);
        }

        return $this->redirectToRoute('secretaire_eleve_liste', [], Response::HTTP_SEE_OTHER);
    }
}
