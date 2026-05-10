<?php

namespace App\Service;

class BingoService
{
    public function jouer(array $choixJoueur, int $mise): array
    {
        //Tirage de 5 boules parmi 10
        $nombresPossibles = range(1, 10);
        shuffle($nombresPossibles);
        $tirage = array_slice($nombresPossibles, 0, 5);

        //Calcul des correspondances
        $matches = array_intersect($choixJoueur, $tirage);
        $nombreDeMatches = count($matches);

        //Tes nouvelles règles de gain
        $gain = 0;
        if ($nombreDeMatches === 5) {
            $gain = $mise * 100; // Jackpot absolu
        } elseif ($nombreDeMatches === 4) {
            $gain = $mise * 5;   // Super gain
        } elseif ($nombreDeMatches === 3) {
            $gain = $mise * 2;   // Mise doublée
        }

        return [
            'tirage' => $tirage,
            'matches' => array_values($matches),
            'gain' => $gain,
            'nbMatches' => $nombreDeMatches
        ];
    }
}