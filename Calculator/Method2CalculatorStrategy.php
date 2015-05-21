<?php

namespace Fduh\PokerBundle\Calculator;

/**
 * Simple calculation.
 */
class Method2CalculatorStrategy implements CalculationStrategyInterface
{
    public function calculate($rank, $numberOfPlayers)
    {
        return $numberOfPlayers - $rank + 1;
    }
}
