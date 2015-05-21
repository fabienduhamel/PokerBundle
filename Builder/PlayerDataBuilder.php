<?php

namespace Fduh\PokerBundle\Builder;

use Fduh\PokerBundle\Entity\Player;
use Fduh\PokerBundle\Handler\Data\PlayerData;

/**
 * Provides builder of PlayerData.
 */
class PlayerDataBuilder
{
    /**
     * @param Player $player
     * @return PlayerData
     */
    public function build(Player $player)
    {
        return new PlayerData($player);
    }
}
