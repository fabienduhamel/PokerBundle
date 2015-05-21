<?php

namespace Fduh\PokerBundle\Handler\Data;

use Fduh\PokerBundle\Entity\Event;

/**
 * Manages multiple events and provides extra information.
 */
interface EventManagerInterface
{
    /**
     * @param Event $event
     */
    public function addEvent(Event $event);

    /**
     * @return Collection of EventData
     */
    public function getEventsData();

    /**
     * @param Event $event
     * @return EventData or null if it does not exist.
     */
    public function getEventData(Event $event);

    /**
     * @return int the maximal score a player is able to do for events set with addEvent.
     */
    public function getMaximalScore();
}
