<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DepotretraitController extends AbstractController
{
    #[Route('/depotretrait', name: 'app_depotretrait')]
    public function index(): Response
    {
        return $this->render('depotretrait/index.html.twig', [
            'controller_name' => 'DepotretraitController',
        ]);
    }
}
