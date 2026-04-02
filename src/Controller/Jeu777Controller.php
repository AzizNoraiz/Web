<?php

namespace App\Controller;

use App\Service\Jeu777Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Jeu777Controller extends AbstractController
{
    #[Route('/jeu777', name: 'app_jeu777')]
    public function index(): Response
    {
        return $this->render('jeu777/index.html.twig');
    }

    #[Route('/jeu777/play', name: 'app_jeu777_play', methods: ['POST'])]
    public function play(Request $request, Jeu777Service $gameService, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['error' => 'Veuillez vous connecter'], 403);

        $data = json_decode($request->getContent(), true);
        $mise = (int) ($data['mise'] ?? 0);

        // --- VERIFICATIONS ---
        if ($mise <= 0) return $this->json(['error' => 'Mise invalide'], 400);
        if ($user->getJetons() < $mise) return $this->json(['error' => 'Jetons insuffisants'], 400);

        // --- LOGIQUE DU JEU ---
        $resultat = $gameService->jouer($mise);

        // --- MISE À JOUR BDD ---
        $user->setJetons($user->getJetons() - $mise + $resultat['gain']);
        $em->flush();

        return $this->json([
            'tirage' => $resultat['tirage'],
            'gain' => $resultat['gain'],
            'isJackpot777' => $resultat['isJackpot777'],
            'nouveauSolde' => $user->getJetons()
        ]);
    }
}