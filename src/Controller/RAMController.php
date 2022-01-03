<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RAMController extends AbstractController
{
    #[Route('/r/a/m', name: 'r_a_m')]
    public function index(): Response
    {
        return $this->render('ram/index.html.twig', [
            'controller_name' => 'RAMController',
        ]);
    }
}
