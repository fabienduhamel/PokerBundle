<?php

namespace FDuh\PokerBundle\Model;

use Fduh\PokerBundle\Calculator\ScoreCalculatorInterface;
use Fduh\PokerBundle\Entity\Player;
use Fduh\PokerBundle\Entity\Season;
use Fduh\PokerBundle\Handler\Data\LastHand;

class Event implements EventInterface
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var Season
     */
    private $season;

    /**
     * @var array<Fduh\PokerBundle\Entity\Result>
     */
    private $results;

    /**
     * @var LastHand
     */
    private $lastHand;

    /**
     * @var boolean
     */
    private $viewable;
    /**
     * @var ScoreCalculatorInterface
     */
    private $scoreCalculator;

    public function __construct(
        \DateTime $date,
        Season $season,
        array $results = array(),
        LastHand $lastHand,
        $viewable,
        ScoreCalculatorInterface $scoreCalculator
    )
    {
        $this->date = $date;
        $this->season = $season;
        $this->results = $results;
        $this->lastHand = $lastHand;
        $this->viewable = $viewable;
        $this->scoreCalculator = $scoreCalculator;
        $this->players = array();

        foreach ($this->results as $result) {
            $player = $result->getPlayer();
            if (!in_array($player, $this->players)) {
                $this->players[] = $player;
            }
        }
    }

    public function __toString()
    {
        return $this->date->format("d-m-Y");
    }

    /**
     * {@inheritDoc}
     */
    public function getLastHand()
    {
        return $this->lastHand;
    }

    /**
     * {@inheritDoc}
     */
    public function getPresentPlayers()
    {
        return $this->players;
    }

    /**
     * {@inheritDoc}
     */
    public function getWinner()
    {
        foreach ($this->results as $result) {
            if ($result->getRank() == 1) {
                return $result->getPlayer();
            }
        }

        throw new \LogicException(
            sprintf("No winner for event %s", $this)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getResult(Player $player)
    {
        foreach ($this->results as $result) {
            if ($result->getPlayer() == $player) {
                return $result;
            }
        }

        throw new \LogicException(
            sprintf("No result for player %s for event %s", $player, $this)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getMaximalScore()
    {
        return $this->scoreCalculator->getMaximalScore($this);
    }
}
