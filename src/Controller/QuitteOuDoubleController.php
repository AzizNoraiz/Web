<?php

namespace App\Controller;

use App\Service\QuitteOuDoubleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuitteOuDoubleController extends AbstractController
{
    #[Route('/quitte-ou-double', name: 'app_quitte_ou_double')]
    public function index(): Response
    {
        return $this->render('jeuquitteoudouble/index.html.twig');
    }

    #[Route('/quitte-ou-double/play', name: 'app_qod_play', methods: ['POST'])]
    public function play(Request $request, QuitteOuDoubleService $gameService, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json(['error' => 'Veuillez vous connecter'], 403);

        $data = json_decode($request->getContent(), true);
        $typePari = $data['typePari'] ?? null; 
        $mise = (int) ($data['mise'] ?? 0);

        // --- VERIFICATIONS ---
        if (!in_array($typePari, ['pair', 'impair'])) return $this->json(['error' => 'Choisissez Pair ou Impair'], 400);
        if ($mise <= 0) return $this->json(['error' => 'Mise invalide'], 400);
        if ($user->getJetons() < $mise) return $this->json(['error' => 'Jetons insuffisants'], 400);

        // --- LOGIQUE ---
        $resultat = $gameService->jouer($typePari, $mise);

        // --- MISE À JOUR BASE DE DONNÉES ---
        $user->setJetons($user->getJetons() - $mise + $resultat['gain']);
        $em->flush();

        return $this->json([
            'tirage' => $resultat['tirage'],
            'gain' => $resultat['gain'],
            'nouveauSolde' => $user->getJetons()
        ]);
    }
}