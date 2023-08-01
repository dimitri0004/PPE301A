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
    public function index(Request $request, EmploiTempsRepository $emploiTempsRepository, PaginatorInterface $paginator): Response
    {
        $ClasseSearch = new ClasseSearch();
        $form = $this->createForm(ClasseSearchType::class, $ClasseSearch);
        $form->handleRequest($request);

        $query = $emploiTempsRepository->createQueryBuilder('et');

        if ($form->isSubmitted() && $form->isValid()) {
            $Classe = $ClasseSearch->getClasse();
            if ($Classe != "") {
                $query->andWhere('et.classe = :classe')
                    ->setParameter('classe', $Classe);
            }
        }

        // Utiliser le paginatge
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), // Numéro de la page. Par défaut : 1
            2 // Nombre d'éléments par page
        );

        return $this->render('eleve/emploi/index.html.twig', [
            'pagination' => $pagination,
            'emploi_temps' => $pagination->getItems(),
            'form' => $form->createView(),
        ]);
    }

}
