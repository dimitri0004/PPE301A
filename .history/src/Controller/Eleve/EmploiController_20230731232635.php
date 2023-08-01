<?php

namespace App\Controller\Eleve;

use App\Entity\ClasseSearch;
use App\Entity\Salle;
use App\Form\ClasseSearchType;
use App\Repository\EmploiTempsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('eleve/emploi',name:'eleve_emploi_temps_')]
class EmploiController extends AbstractController
{
    
    #[Route('/ds', name: '')]
    public function d(): Response
    {
        return $this->render('emploi/ndex.html.twig', [
            'controller_name' => 'EmploiController',
        ]);
    }

    #[Route('/', name: 'liste')]
    public function index(Request $request, EmploiTempsRepository $emploiTempsRepository): Response
    {
        $ClasseSearch = new ClasseSearch();
        $form = $this->createForm(ClasseSearchType::class, $ClasseSearch);
        $form->handleRequest($request);
        $page=$request -> query->getInt('page',  1);

        $emploiTemps = [];
        
        if ($form->isSubmitted() && $form->isValid()) {
            $Classe = $ClasseSearch->getClasse();
            if ($Classe != "") {
            
                $emploiTemps=$Classe->getEmploiTemps()->findEmploipaginated($page,2);

            } else {
            
                $emploiTemps=$emploiTempsRepository->findEmploipaginated($page,2);
            }

        }else{
            $emploiTemps=$emploiTempsRepository->findEmploipaginated($page,2);
        }


        
        
        $emploiTemps=$emploiTempsRepository->findEmploipaginated($page,2);

        return $this->render('eleve/emploi/index.html.twig', [
            'emploiTemps' => $emploiTemps,
            
            'form' => $form->createView(),
            
            
        ]);
    }

}
