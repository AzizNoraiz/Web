<?php

namespace App\Controller;

use App\Service\BingoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeubingoController extends AbstractController
{
    #[Route('/jeubingo', name: 'app_jeubingo')]
    public function index(): Response
    {
        return $this->render('jeubingo/index.html.twig');
    }

    #[Route('/jeubingo/play', name: 'app_bingo_play', methods: ['POST'])]
    public function play(Request $request, BingoService $bingoService, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['error' => 'Veuillez vous connecter'], 403);

        $data = json_decode($request->getContent(), true);
        $choix = $data['choix'] ?? [];
        $mise = (int) ($data['mise'] ?? 0);

        if (count($choix) !== 3) return $this->json(['error' => 'Sélectionnez exactement 3 numéros'], 400);
        if ($user->getJetons() < $mise) return $this->json(['error' => 'Jetons insuffisants'], 400);

        // Lancer le jeu
        $resultat = $bingoService->jouer($choix, $mise);

        // Mise à jour de l'utilisateur
        $user->setJetons($user->getJetons() - $mise + $resultat['gain']);
        $em->flush();

        return $this->json([
            'tirage' => $resultat['tirage'],
            'gain' => $resultat['gain'],
            'nouveauSolde' => $user->getJetons(),
            'nbMatches' => $resultat['nbMatches']
        ]);
    }
}