<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteCntrollerController extends AbstractController
{
    #[Route('/note/cntroller', name: 'app_note_cntroller')]
    public function index(): Response
    {
        return $this->render('note_cntroller/index.html.twig', [
            'controller_name' => 'NoteCntrollerController',
        ]);
    }
}
