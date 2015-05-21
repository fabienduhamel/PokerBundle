<?php

namespace Fduh\PokerBundle\Calculator;

use Fduh\PokerBundle\Entity\Event;
use Fduh\PokerBundle\Entity\Result;

class ScoreCalculator implements ScoreCalculatorInterface
{
    /**
     * @var CalculationStrategyInterface
     */
    private $calculationStrategy;

    /**
     * @param CalculationStrategyInterface $calculationStrategy
     */
    public function __construct(CalculationStrategyInterface $calculationStrategy)
    {
        $this->calculationStrategy = $calculationStrategy;
    }

    public function calculateScore(Result $result)
    {
        $numberOfPlayers = count($result->getEvent()->getResults());

        return $this->calculationStrategy->calculate($result->getRank(), $numberOfPlayers);
    }

    public function getMaximalScore(Event $event)
    {
        $result = new Result();
        $result->setRank(1);
        $numberOfPlayers = count($event->getResults());

        return $this->calculationStrategy->calculate($result->getRank(), $numberOfPlayers);
    }
}
