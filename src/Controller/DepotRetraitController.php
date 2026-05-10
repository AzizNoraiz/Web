<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DepotRetraitController extends AbstractController
{
    #[Route('/depotretrait', name: 'app_depot_retrait')]
    public function index(): Response
    {
        // Redirige vers la connexion si l'utilisateur n'est pas connecté
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); 
        }

        return $this->render('depot_retrait/index.html.twig');
    }

    #[Route('/depotretrait/transaction', name: 'app_depot_retrait_transaction', methods: ['POST'])]
    public function transaction(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['error' => 'Veuillez vous connecter'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $montant = (int) ($data['montant'] ?? 0);
        $action = $data['action'] ?? ''; // 'depot' ou 'retrait'

        // Vérifications de base
        if ($montant <= 0) {
            return $this->json(['error' => 'Veuillez entrer un montant valide supérieur à 0.'], 400);
        }
        /** @var \App\Entity\Personne $user */
        $soldeActuel = $user->getJetons();

        // Logique de transaction
        if ($action === 'depot') {
            $user->setJetons($soldeActuel + $montant);
            $message = "Dépôt de $montant jetons effectué avec succès.";
        } elseif ($action === 'retrait') {
            if ($soldeActuel < $montant) {
                return $this->json(['error' => 'Fonds insuffisants pour ce retrait.'], 400);
            }
            $user->setJetons($soldeActuel - $montant);
            $message = "Retrait de $montant jetons effectué avec succès.";
        } else {
            return $this->json(['error' => 'Action non reconnue.'], 400);
        }

        // Sauvegarde en base de données
        $em->flush();

        return $this->json([
            'success' => true,
            'nouveauSolde' => $user->getJetons(),
            'message' => $message
        ]);
    }
}