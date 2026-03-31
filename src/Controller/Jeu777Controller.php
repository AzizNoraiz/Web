<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Jeu777Controller extends AbstractController
{
    #[Route('/jeu777', name: 'app_jeu777', methods: ['GET'])]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('jeu777/index.html.twig', [
            'jetons' => $user->getJetons(),
        ]);
    }

    #[Route('/jeu777/jouer', name: 'app_jeu777_jouer', methods: ['POST'])]
    public function jouer(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $mise = (int) $request->request->get('mise', 10);

        // --- Validation ---
        if ($mise <= 0 || $mise > $user->getJetons()) {
            $this->addFlash('error', 'Mise invalide ou jetons insuffisants.');
            return $this->redirectToRoute('app_jeu777');
        }

        // --- Génération des rouleaux : $rouleaux[colonne][ligne] ---
        $rouleaux = [];
        for ($col = 0; $col < 3; $col++) {
            for ($ligne = 0; $ligne < 3; $ligne++) {
                $rouleaux[$col][$ligne] = random_int(1, 10);
            }
        }

        // --- Vérification des lignes gagnantes ---
        $lignesGagnantes = [];
        for ($ligne = 0; $ligne < 3; $ligne++) {
            if (
                $rouleaux[0][$ligne] === $rouleaux[1][$ligne] &&
                $rouleaux[1][$ligne] === $rouleaux[2][$ligne]
            ) {
                $lignesGagnantes[] = $ligne;
            }
        }

        // --- Calcul du gain : x2 par ligne gagnante ---
        $gain = count($lignesGagnantes) > 0 ? $mise * (2 * count($lignesGagnantes)) : 0;

        // --- Mise à jour BDD ---
        $user->setJetons($user->getJetons() - $mise + $gain);
        $em->flush();

        return $this->render('jeu777/index.html.twig', [
            'jetons'          => $user->getJetons(),
            'rouleaux'        => $rouleaux,
            'mise'            => $mise,
            'gain'            => $gain,
            'lignesGagnantes' => $lignesGagnantes,
            'aJoue'           => true,
        ]);
    }
}
