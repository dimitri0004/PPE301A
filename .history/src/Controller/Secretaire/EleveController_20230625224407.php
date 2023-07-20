<?php

namespace App\Controller\Secretaire;

use App\Entity\Eleve;
use App\Entity\Classe;
use App\Form\EleveType;
use App\Repository\AnneRepository;
use App\Repository\ClasseRepository;
use App\Repository\EleveRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('secretaire/eleve' , name: 'secretaire_eleve_')]
class EleveController extends AbstractController
{
    #[Route('/', name: 'liste', methods: ['GET'])]
    public function index(Request $request, ClasseRepository $classeRepository, AnneRepository $anneeRepository, EleveRepository $eleveRepository): Response
    {
    // Récupérer les valeurs de classe et d'année depuis la requête
    $classeId = $request->query->get('classe');
    $anneeId = $request->query->get('annee');

    // Récupérer la classe et l'année correspondantes
    $classe = null;
    $annee = null;

            if ($classeId) {
                $classe = $classeRepository->find($classeId);
            

            if ($anneeId) {
                $annee = $anneeRepository->find($anneeId);
            
            $eleves = [];
            $searchTerm = $request->query->get('search');
            if ($searchTerm !='') {
                $eleves = $eleveRepository->findByNom($searchTerm);
            }else{
                $eleves = $eleveRepository->findBy([
                    'classe' => $classe,
                    'anne' => $annee
                ]); 
            }
        }    
    }
            // Rechercher les élèves correspondants en fonction de la classe et de l'année
            $eleves = $eleveRepository->findBy([
                'classe' => $classe,
                'anne' => $annee
            ]);

       
        

            // Récupérer la liste complète des classes et années pour le formulaire
            $classes = $classeRepository->findAll();
            $annees = $anneeRepository->findAll();


    return $this->render('secretaire/eleve/index.html.twig', [
        'classes' => $classes,
        'annees' => $annees,
        'eleves' => $eleves,
        'classeSelectionnee' => $classe,
        'anneeSelectionnee' => $annee,
        'search' => $searchTerm,
    ]);

}

    #[Route('/liste', name: 'listetrier', methods: ['GET'])]
    public function liste(Request $request, ClasseRepository $classeRepository, AnneRepository $anneeRepository, EleveRepository $eleveRepository): Response
    {
    // Récupérer les valeurs de classe et d'année depuis la requête
    $classeId = $request->query->get('classe');
    $anneeId = $request->query->get('annee');

    // Récupérer la classe et l'année correspondantes
    $classe = null;
    $annee = null;

        if ($classeId) {
                $classe = $classeRepository->find($classeId);
            }

            if ($anneeId) {
                $annee = $anneeRepository->find($anneeId);
            }

            // Rechercher les élèves correspondants en fonction de la classe et de l'année
            $eleves = $eleveRepository->findBy([
                'classe' => $classe,
                'anne' => $annee
            ]);

            // Récupérer la liste complète des classes et années pour le formulaire
            $classes = $classeRepository->findAll();
            $annees = $anneeRepository->findAll();

    return $this->render('secretaire/eleve/liste.html.twig', [
        'classes' => $classes,
        'annees' => $annees,
        'eleves' => $eleves,
        'classeSelectionnee' => $classe,
        'anneeSelectionnee' => $annee,
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
        return $this->renderForm('secretaire/eleve/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Eleve $eleve): Response
    {
        return $this->render('secretaire/eleve/show.html.twig', [
            'eleve' => $eleve,
        ]);
    }



    #[Route('modifier/{id}', name: 'modifier', methods: ['GET', 'POST'])]
    public function edit(Eleve $Eleve, Request $request,UserPasswordHasherInterface $userPasswordHasher, EleveRepository $EleveRepository, EntityManagerInterface $entityManagerInterface,): Response
    {
        $form = $this->createForm(EleveType::class, $Eleve);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
            $this-> addFlash('success', 'L\'Eleve a été modifier avec succes');

            

           return $this->redirectToRoute('secretaire_eleve_liste');
            #$eleveRepository->save($eleve, true);

            #return $this->redirectToRoute('secretaire_eleve_liste', [], Response::HTTP_SEE_OTHER);
        }
        }
        return $this->renderForm('secretaire/eleve/edit.html.twig', [
            'eleve' => $Eleve,
            'form' => $form,
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
