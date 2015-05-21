<?php

namespace Fduh\PokerBundle\Handler\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Fduh\PokerBundle\Builder\EventDataBuilder;
use Fduh\PokerBundle\Entity\Event;

class EventManager implements EventManagerInterface
{
    /**
     * @var EventDataBuilder
     */
    private $eventsDataBuilder;

    /**
     * @var ArrayCollection
     */
    private $eventsData;

    /**
     * @param EventDataBuilder $eventDataBuilder
     */
    public function __construct(EventDataBuilder $eventDataBuilder)
    {
        $this->eventsDataBuilder = $eventDataBuilder;
        $this->eventsData = new ArrayCollection();
    }

    public function addEvent(Event $event)
    {
        $eventData = $this->eventsDataBuilder->build($event);
        $this->eventsData->set($event->getId(), $eventData);
    }

    public function getEventsData()
    {
        return $this->eventsData;
    }

    public function getEventData(Event $event)
    {
        return $this->eventsData->get($event->getId());
    }

    public function getMaximalScore()
    {
        $maximalScore = 0;
        foreach ($this->eventsData as $eventData) {
            $maximalScore += $eventData->getMaximalScore();
        }

        return $maximalScore;
    }
}
