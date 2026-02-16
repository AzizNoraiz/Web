<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Jeu777Controller extends AbstractController
{
    #[Route('/jeu777', name: 'app_jeu777')]
    public function index(): Response
    {
        return $this->render('jeu777/index.html.twig', [
            'controller_name' => 'Jeu777Controller',
        ]);
    }
}
