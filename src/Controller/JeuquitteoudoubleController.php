<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JeuquitteoudoubleController extends AbstractController
{
    #[Route('/jeuquitteoudouble', name: 'app_jeuquitteoudouble')]
    public function index(): Response
    {
        return $this->render('jeuquitteoudouble/index.html.twig', [
            'controller_name' => 'JeuquitteoudoubleController',
        ]);
    }
}
