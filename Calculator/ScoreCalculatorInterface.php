<?php

namespace Fduh\PokerBundle\Calculator;

use Fduh\PokerBundle\Entity\Event;
use Fduh\PokerBundle\Entity\Result;

/**
 * Calculates score of a given result or event.
 */
interface ScoreCalculatorInterface
{
    /**
     * @param Event $event
     * @return int the maximal score of $event
     */
    public function getMaximalScore(Event $event);

    /**
     * @param Result $result
     * @return int the score for $result
     */
    public function calculateScore(Result $result);
}
