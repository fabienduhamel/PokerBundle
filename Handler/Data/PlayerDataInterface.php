<?php

namespace Fduh\PokerBundle\Handler\Data;

use Fduh\PokerBundle\Entity\Event;

/**
 * A player with more information.
 */
interface PlayerDataInterface
{
    /**
     * @return Player
     */
    public function getPlayer();

    /**
     * @param EventDataInterface $eventData
     */
    public function addEventData(EventDataInterface $eventData);

    /**
     * @return Collection of Event
     */
    public function getPlayedEvents();

    /**
     * @param Event $event
     * @return int
     */
    public function getScore(Event $event);

    /**
     * @return int
     */
    public function getTotal();

    /**
     * @param Event $event
     * @return int
     */
    public function getRank(Event $event);

    /**
     * @return Collection of Events
     */
    public function getWonEvents();

    /**
     * @return float
     */
    public function getWinRate();

    /**
     * @return float
     */
    public function getPointsRate();

    /**
     * @return float
     */
    public function getAveragePointsPerEvent();

    /**
     * @return int
     */
    public function getMaximalTotal();

    /**
     * @param $rank
     * @return int
     */
    public function getNumberOfPlaces($rank);

    /**
     * @return int
     */
    public function getWorstPlace();
}
