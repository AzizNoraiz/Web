<?php

namespace App\Service;

class Jeu777Service
{
    public function jouer(int $mise): array
    {
        //Tirage de 3 chiffres entre 1 et 9
        $tirage = [rand(1, 9), rand(1, 9), rand(1, 9)];
        
        // Analyse du tirage (compter combien de fois chaque chiffre apparaît)
        $comptes = array_count_values($tirage);
        $maxIdentiques = max($comptes); // ex: 3 si 7-7-7, 2 si 4-4-8
        $aUnSept = in_array(7, $tirage);

        //Application de tes règles strictes
        $gain = 0;
        
        if ($maxIdentiques === 3) {
            if ($tirage[0] === 7) {
                $gain = $mise * 100; // 7-7-7 = x100
            } else {
                $gain = $mise * 50;  // 3 identiques (ex: 5-5-5) = x50
            }
        } elseif ($maxIdentiques === 2) {
            $gain = $mise * 5;       // 2 identiques (ex: 8-8-2) = x5
        } elseif ($aUnSept) {
            $gain = $mise;           // Au moins un 7 (et pas de paires) = Remboursé x1
        }

        return [
            'tirage' => $tirage,
            'gain' => $gain,
            'maxIdentiques' => $maxIdentiques,
            'isJackpot777' => ($maxIdentiques === 3 && $tirage[0] === 7)
        ];
    }
}