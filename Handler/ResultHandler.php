<?php

namespace Fduh\PokerBundle\Handler;

use Doctrine\Common\Collections\Collection;
use Fduh\PokerBundle\Entity\Season;
use Fduh\PokerBundle\Handler\Data\EventDataInterface;
use Fduh\PokerBundle\Handler\Data\EventManagerInterface;
use Fduh\PokerBundle\Handler\Data\PlayerManagerInterface;

class ResultHandler implements ResultHandlerInterface
{
    /**
     * @var Season
     */
    private $season;

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * @var PlayerManagerInterface
     */
    private $playerManager;

    /**
     * @param EventManagerInterface  $eventManager
     * @param PlayerManagerInterface $playerManager
     */
    public function __construct(EventManagerInterface $eventManager, PlayerManagerInterface $playerManager)
    {
        $this->playerManager = $playerManager;
        $this->eventManager = $eventManager;
    }

    public function setSeason(Season $season)
    {
        $this->season = $season;
        $this->addEvents($season->getEvents());
    }

    public function addEvents(Collection $events)
    {
        foreach ($events as $event) {
            $this->eventManager->addEvent($event);
            $eventData = $this->eventManager->getEventData($event);
            $this->updatePlayersData($eventData);
        }
    }

    /**
     * Foreach eventData created, all PlayerData are hydrated with it.
     *
     * @param EventDataInterface $eventData
     */
    private function updatePlayersData(EventDataInterface $eventData)
    {
        $presentPlayers = $eventData->getPresentPlayers();
        foreach ($presentPlayers as $player) {
            $this->playerManager->addEventData($player, $eventData);
        }
    }

    public function getPlayerManager()
    {
        return $this->playerManager;
    }

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function getSeason()
    {
        return $this->season;
    }
}
