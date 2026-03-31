<?php

namespace App\Service;

class QuitteOuDoubleService
{
    public function jouer(string $typePari, int $mise): array
    {
        // 1. Le destin : un chiffre entre 0 et 36
        $tirage = rand(0, 36);
        $gain = 0;

        // 2. Calcul du gain
        if ($tirage === 0) {
            // Le Zéro est spécial (Jackpot)
            if ($typePari === 'zero') {
                $gain = $mise * 35;
            }
        } else {
            // Pair ou Impair (le 0 ne compte pas comme pair ici selon les règles casino)
            $isPair = ($tirage % 2 === 0);
            
            if ($typePari === 'pair' && $isPair) {
                $gain = $mise * 2;
            } elseif ($typePari === 'impair' && !$isPair) {
                $gain = $mise * 2;
            }
        }

        return [
            'tirage' => $tirage,
            'gain' => $gain,
            'isWin' => $gain > 0
        ];
    }
}