<?php

namespace App\Service;

class QuitteOuDoubleService
{
    public function jouer(string $typePari, int $mise): array
    {
        //Le destin : un chiffre entre 1 et 100 (50% pair, 50% impair)
        $tirage = rand(1, 100);
        $gain = 0;

        //Calcul du gain
        $isPair = ($tirage % 2 === 0);
        
        if ($typePari === 'pair' && $isPair) {
            $gain = $mise * 2;
        } elseif ($typePari === 'impair' && !$isPair) {
            $gain = $mise * 2;
        }

        return [
            'tirage' => $tirage,
            'gain' => $gain,
            'isWin' => $gain > 0
        ];
    }
}