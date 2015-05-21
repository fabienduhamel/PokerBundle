<?php

namespace Fduh\PokerBundle\Handler\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Fduh\PokerBundle\Entity\Event;
use Fduh\PokerBundle\Entity\Player;

class PlayerData implements PlayerDataInterface
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var ArrayCollection
     */
    private $eventsData;

    /**
     * @var ArrayCollection
     */
    private $results;

    /**
     * @var int
     */
    private $total;

    /**
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        $this->player = $player;
        $this->eventsData = new ArrayCollection();
        $this->results = new ArrayCollection();
        $this->total = 0;
    }

    public function getPlayer()
    {
        return $this->player;
    }

    public function addEventData(EventDataInterface $eventData)
    {
        $this->eventsData->add($eventData);
        $this->updateResults($eventData);

    }

    private function updateResults(EventDataInterface $eventData)
    {
        $result = $eventData->getResult($this->player);
        if ($result) {
            $this->results->set($eventData->getEvent()->getId(), $result);
            $this->total += $result->getScore();
        }
    }

    public function getPlayedEvents()
    {
        $events = new ArrayCollection();
        foreach ($this->eventsData as $eventData) {
            $events->add($eventData->getEvent());
        }

        return $events;
    }

    public function getScore(Event $event)
    {
        if (isset($this->results[$event->getId()])) {
            return $this->results[$event->getId()]->getScore();
        }

        return 0;
    }

    public function getRank(Event $event)
    {
        if (isset($this->results[$event->getId()])) {
            return $this->results[$event->getId()]->getRank();
        }

        return 0;
    }

    public function getWonEvents()
    {
        $wonEvents = new ArrayCollection();
        foreach ($this->results as $result) {
            if ($result->getRank() == 1) {
                $wonEvents->add($result->getEvent());
            }
        }

        return $wonEvents;
    }

    public function getWinRate()
    {
        $wonEventsCount = $this->getWonEvents()->count();
        $playedEventsCount = $this->results->count();

        return number_format($wonEventsCount / $playedEventsCount * 100, 1);
    }

    public function getPointsRate()
    {
        $maximalScore = 0;
        foreach ($this->eventsData as $eventData) {
            $maximalScore += $eventData->getMaximalScore();
        }

        return number_format($this->total / $maximalScore * 100, 1);
    }

    public function getAveragePointsPerEvent()
    {
        $playedEventsCount = $this->results->count();

        return number_format($this->total / $playedEventsCount, 1);
    }

    public function getMaximalTotal()
    {
        $maximalTotal = 0;
        foreach ($this->eventsData as $eventData) {
            if ($eventData->getResult($this->player)) {
                $maximalTotal += $eventData->getMaximalScore();
            }
        }

        return $maximalTotal;
    }

    public function getNumberOfPlaces($rank)
    {
        $placesCount = 0;
        foreach ($this->results as $result) {
            if ($result->getRank() == $rank) {
                $placesCount++;
            }
        }

        return $placesCount;
    }

    public function getWorstPlace()
    {
        $worstPlace = 0;
        foreach ($this->results as $result) {
            if ($worstPlace == 0) {
                $worstPlace = $result->getRank();
            }
            if ($result->getRank() > $worstPlace) {
                $worstPlace = $result->getRank();
            }
        }

        return $worstPlace;
    }

    public function getTotal()
    {
        return $this->total;
    }
}
