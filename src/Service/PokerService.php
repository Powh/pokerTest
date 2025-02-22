<?php

namespace App\Service;

use App\Enum\GameResult;

class PokerService
{
    const defaultHand = "KS 2H 5C JD TD";
    const valuesCardList = ["2", "3", "4", "5", "6", "7", "8", "9", "T", "J", "Q", "K", "A"];

    /**
     * Compare notre main avec la main par défaut et retourne le résultat de la manche
     * @param string $hand
     * @return GameResult
     */
    public function compareWith(string $hand): GameResult
    {
        $arrayHand = explode(" ", $hand);

        $handValues = $this->getValues($arrayHand);
        $handColors = $this->getColors($arrayHand);

        if ($this->checkPairMinimum($handValues)) return GameResult::Win;
        if ($this->checkStraight($handValues)) return GameResult::Win;
        if ($this->checkFlush($handColors)) return GameResult::Win;

        return $this->checkHighCard($handValues);
    }

    /**
     * Récupère les valeurs de notre main : 2,3,K,Q...
     * @param array $hand
     * @return array
     */
    public function getValues(array $hand): array
    {
        $values = array_map(function($item) {
            return substr($item, 0, -1);
        }, $hand);

        return $values;
    }

    /**
     * Récupère les couleurs de notre main : S, H, D, C
     * @param array $hand
     * @return array
     */
    public function getColors(array $hand): array
    {
        $values = array_map(function($item) {
            return substr($item, 1);
        }, $hand);

        return $values;
    }

    /**
     * Vérifie si l'on a au moins une paire qui est déjà supérieur à la main par défaut
     * @param array $handValues
     * @return bool
     */
    public function checkPairMinimum(array $handValues): bool
    {
        $counts = array_count_values($handValues);

        foreach ($counts as $nbSameCard)
        {
            if ($nbSameCard > 1)
            {
                return true;
            }
        }

        return false;
    }

    /**
     * Vérifie si on a une suite
     * @param array $handValues
     * @return bool
     */
    public function checkStraight(array $handValues): bool
    {
        $points = $this->convertToPoint($handValues);
        sort($points);
        for ($i = 1; $i < count($points); $i++) {
            if ($points[$i] !== $points[$i - 1] + 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * Vérifie les cartes les plus hautes sur les 2 mains
     * @param array $handValues
     * @return GameResult
     */
    public function checkHighCard(array $handValues): GameResult
    {
        $points = $this->convertToPoint($handValues);
        $pointsDefaultHand = $this->convertToPoint($this->getValues(explode(" ", self::defaultHand)));

        rsort($points);
        rsort($pointsDefaultHand);

        foreach ($points as $key => $point)
        {
            if ($point > $pointsDefaultHand[$key])
            {
                return GameResult::Win;
            }

            if ($point < $pointsDefaultHand[$key])
            {
                return GameResult::Lose;
            }
        }

        return GameResult::Tie;
    }

    /**
     * Vérifie si on a une couleur
     * @param array $handColors
     * @return bool
     */
    public function checkFlush(array $handColors): bool
    {
        $counts = array_count_values($handColors);

        return reset($counts) == 5;
    }

    /**
     * Convertie les valeurs des cartes en points
     * pour vérifier la suite ou la main avec la plus haute valeur
     * @param array $handValues
     * @return array
     */
    private function convertToPoint(array $handValues)
    {
        $points = [];
        foreach ($handValues as $value)
        {
            $points[] = array_search($value, self::valuesCardList);
        }

        return $points;
    }
}