<?php

namespace Fduh\PokerBundle\Handler;

use Doctrine\Common\Collections\Collection;
use Fduh\PokerBundle\Entity\Season;

/**
 * Handles results, events and players.
 */
interface ResultHandlerInterface
{
    /**
     * @param Season $season
     */
    public function setSeason(Season $season);

    /**
     * @param Collection $events
     */
    public function addEvents(Collection $events);

    /**
     * @return PlayerManager
     */
    public function getPlayerManager();

    /**
     * @return EventManager
     */
    public function getEventManager();

    /**
     * @return Season
     */
    public function getSeason();
}
