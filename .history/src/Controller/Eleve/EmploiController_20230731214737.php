<?php

namespace App\Controller\Eleve;

use App\Entity\ClasseSearch;
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

        $emploiTemps = [];
        
        if ($form->isSubmitted() && $form->isValid()) {
            $Classe = $ClasseSearch->getClasse();
            if ($Classe != "") {
            
                $emploiTemps=$Classe->getEmploiTemps();
            } else {
            
                $emploiTemps = $emploiTempsRepository->findAll();
            }

        }else{
            $emploiTemps = $emploiTempsRepository->findAll();
        }


        


        return $this->render('directeur/emploi_temps/index.html.twig', [
            'emploiTemps' => $emploiTemps,
            'emploi_temps' => $emploiTemps,
            'form' => $form->createView(),
            
            
        ]);
    }

}