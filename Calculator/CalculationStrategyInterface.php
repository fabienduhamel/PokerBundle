<?php

namespace Fduh\PokerBundle\Calculator;

/**
 * Provides a strategy to calculate scores
 */
interface CalculationStrategyInterface
{
    /**
     * @param $rank
     * @param $numberOfPlayers
     * @return int the calculated score for $rank with $numberOfPlayers
     */
    public function calculate($rank, $numberOfPlayers);
}
