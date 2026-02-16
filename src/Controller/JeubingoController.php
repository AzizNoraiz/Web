<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JeubingoController extends AbstractController
{
    #[Route('/jeubingo', name: 'app_jeubingo')]
    public function index(): Response
    {
        return $this->render('jeubingo/index.html.twig', [
            'controller_name' => 'JeubingoController',
        ]);
    }
}
