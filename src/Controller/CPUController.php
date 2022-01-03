<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CPUController extends AbstractController
{
    #[Route('/c/p/u', name: 'c_p_u')]
    public function index(): Response
    {
        return $this->render('cpu/index.html.twig', [
            'controller_name' => 'CPUController',
        ]);
    }
}
