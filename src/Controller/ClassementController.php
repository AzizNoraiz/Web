<?php

namespace App\Controller;

use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClassementController extends AbstractController
{
    #[Route('/classement', name: 'app_classement')]
    public function index(PersonneRepository $personneRepository): Response
    {
        // On récupère les 10 joueurs avec le plus de jetons, triés par ordre décroissant
        $topJoueurs = $personneRepository->findBy(
            [], // Pas de critères de filtre spécifiques (on prend tous les utilisateurs)
            ['jetons' => 'DESC'], // Tri par jetons : du plus grand au plus petit
            10 // Limite : on ne veut que le Top 10
        );

        return $this->render('classement/index.html.twig', [
            'joueurs' => $topJoueurs,
        ]);
    }
}