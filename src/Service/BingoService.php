<?php

namespace App\Service;

class BingoService
{
    public function jouer(array $choixJoueur, int $mise): array
    {
        // 1. Tirage de 5 boules uniques entre 1 et 10
        $tirage = [];
        $nombresPossibles = range(1, 10);
        shuffle($nombresPossibles);
        $tirage = array_slice($nombresPossibles, 0, 5);

        // 2. Calcul des correspondances (combien de chiffres choisis sont dans le tirage)
        $matches = array_intersect($choixJoueur, $tirage);
        $nombreDeMatches = count($matches);

        // 3. Calcul du gain selon tes règles
        $gain = 0;
        if ($nombreDeMatches === 3) {
            $gain = $mise * 20;
        } elseif ($nombreDeMatches === 2) {
            $gain = $mise * 5;
        } elseif ($nombreDeMatches === 1) {
            $gain = $mise; // Remboursé
        }

        return [
            'tirage' => $tirage,
            'matches' => array_values($matches),
            'gain' => $gain,
            'nbMatches' => $nombreDeMatches
        ];
    }
}