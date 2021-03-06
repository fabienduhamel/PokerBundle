<?php

namespace Fduh\PokerBundle\Handler\Data;

use Fduh\PokerBundle\Entity\Player;

/**
 * An event with more information.
 */
interface EventDataInterface
{
    /**
     * @return Event
     */
    public function getEvent();

    /**
     * @param Player $player
     * @return Result
     */
    public function getResult(Player $player);

    /**
     * @return LastHand
     */
    public function getLastHand();

    /**
     * @return Collection of Player
     */
    public function getPresentPlayers();

    /**
     * @return Player
     */
    public function getWinner();

    /**
     * @return int
     */
    public function getMaximalScore();
}
