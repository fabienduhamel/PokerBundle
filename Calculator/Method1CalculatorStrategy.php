<?php

namespace Fduh\PokerBundle\Calculator;

/**
 * Complex calculation granting exponential points by rank.
 */
class Method1CalculatorStrategy implements CalculationStrategyInterface
{
    public function calculate($rank, $numberOfPlayers)
    {
        $n = $numberOfPlayers;
        $k = $rank;
        $bMultiplicator = ($n - 2);
        $a = $bMultiplicator % 2 == 0 ? $bMultiplicator / 2 : ($bMultiplicator - 1) / 2;
        $aImpair = $bMultiplicator % 2 == 0 ? 1 : 3.16;
        $bMultiplicator = pow(10, $a) * $aImpair;
        $b = 100 * $bMultiplicator;
        $q = $numberOfPlayers - $k + 1;
        $p = (10 * sqrt($n / $k) * (1 + log10($b * $n)) - ($k * $k) + $q * $q) / 2.15;

        return ($p > 1 ? number_format($p, 0) : 1);
    }
}
