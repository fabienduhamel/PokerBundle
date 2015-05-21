<?php

namespace Fduh\PokerBundle\Handler\Data;

use Fduh\PokerBundle\Entity\Player;

/**
 * Manages players and provides extra information.
 */
interface PlayerManagerInterface
{
    /**
     * @param Player             $player
     * @param EventDataInterface $eventData
     */
    public function addEventData(Player $player, EventDataInterface $eventData);

    /**
     * @return Collection of PlayerData
     */
    public function getPlayersData();

    /**
     * @param Player $player
     * @return PlayerData or null if it does not exist.
     */
    public function getPlayerData(Player $player);

    /**
     * @param Player $player
     * @return int the rank of the player or 0 if does not exist.
     */
    public function getRank(Player $player);
}
