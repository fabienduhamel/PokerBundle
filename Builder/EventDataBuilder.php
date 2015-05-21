<?php

namespace Fduh\PokerBundle\Builder;

use Fduh\PokerBundle\Calculator\ScoreCalculatorInterface;
use Fduh\PokerBundle\Entity\Event;
use Fduh\PokerBundle\Handler\Data\EventData;

/**
 * Provides builder of EventData.
 */
class EventDataBuilder
{
    private $scoreCalculator;

    /**
     * @param ScoreCalculatorInterface $scoreCalculator
     */
    public function __construct(ScoreCalculatorInterface $scoreCalculator)
    {
        $this->scoreCalculator = $scoreCalculator;
    }

    /**
     * @param Event $event
     * @return EventData
     */
    public function build(Event $event)
    {
        return new EventData($event, $this->scoreCalculator);
    }
}
