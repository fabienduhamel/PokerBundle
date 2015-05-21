<?php

namespace Fduh\PokerBundle\Handler\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Fduh\PokerBundle\Calculator\ScoreCalculatorInterface;
use Fduh\PokerBundle\Entity\Event;
use Fduh\PokerBundle\Entity\Player;

class EventData implements EventDataInterface
{

    /**
     * @var Event
     */
    private $event;

    /**
     * @var ScoreCalculator
     */
    private $scoreCalculator;

    /**
     * @var LastHand
     */
    private $lastHand;

    /**
     * @var ArrayCollection
     */
    private $players;

    /**
     * @param Event           $event
     * @param ScoreCalculator $scoreCalculator
     */
    public function __construct(Event $event, ScoreCalculatorInterface $scoreCalculator)
    {
        $this->event = $event;
        $this->players = new ArrayCollection();
        $this->scoreCalculator = $scoreCalculator;
        if ($event->getLastHand()) {
            $this->lastHand = new LastHand($event->getLastHand());
        }

        $this->updatePlayers();
    }

    /**
     * Hydrates players with present players of events.
     */
    private function updatePlayers()
    {
        foreach ($this->event->getResults() as $result) {
            $player = $result->getPlayer();
            if (!$this->players->contains($player)) {
                $this->players->add($player);
            }
        }
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function getLastHand()
    {
        return $this->lastHand;
    }

    public function getPresentPlayers()
    {
        return $this->players;
    }

    public function getWinner()
    {
        foreach ($this->event->getResults() as $result) {
            if ($result->getRank() == 1) {
                return $result->getPlayer();
            }
        }
        throw new \LogicException("No winner for event " . $this->event);
    }

    public function getResult(Player $player)
    {
        foreach ($this->event->getResults() as $result) {
            if ($result->getPlayer() == $player) {
                return $result;
            }
        }

        return null;
    }

    public function getMaximalScore()
    {
        return $this->scoreCalculator->getMaximalScore($this->event);
    }
}
