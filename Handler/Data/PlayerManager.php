<?php

namespace Fduh\PokerBundle\Handler\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Fduh\PokerBundle\Builder\PlayerDataBuilder;
use Fduh\PokerBundle\Entity\Player;
use Fduh\PokerBundle\Sorter\PlayerDataSorter;

class PlayerManager implements PlayerManagerInterface
{
    /**
     * @var ArrayCollection
     */
    private $playersData;

    /**
     * @var PlayerDataBuilder
     */
    private $playerDataBuilder;

    /**
     * @var PlayerDataSorter
     */
    private $playerDataSorter;

    /**
     * @param PlayerDataBuilder $playerDataBuilder
     * @param PlayerDataSorter  $playerDataSorter
     */
    public function __construct(PlayerDataBuilder $playerDataBuilder, PlayerDataSorter $playerDataSorter)
    {
        $this->playersData = new ArrayCollection();
        $this->playerDataBuilder = $playerDataBuilder;
        $this->playerDataSorter = $playerDataSorter;
    }

    public function addEventData(Player $player, EventDataInterface $eventData)
    {
        $playerData = $this->getPlayerData($player);
        if (!$playerData) {
            $playerData = $this->addPlayer($player);
        }
        $playerData->addEventData($eventData);
        $this->playersData = $this->playerDataSorter->sortByTotalDesc($this->playersData);
    }

    /**
     * Creates a PlayerData if it does not already exist.
     *
     * @param Player $player
     * @return PlayerData just created
     */
    private function addPlayer(Player $player)
    {
        $playerData = $this->getPlayerData($player);
        if (!$playerData) {
            $playerData = $this->playerDataBuilder->build($player);
            $this->playersData->set($player->getId(), $playerData);
        }

        return $playerData;
    }

    public function getPlayersData()
    {
        return $this->playersData;
    }

    public function getPlayerData(Player $player)
    {
        return $this->playersData->get($player->getId());
    }

    public function getRank(Player $player)
    {
        $rank = 0;
        foreach ($this->playersData as $playerData) {
            $rank++;
            if ($playerData->getPlayer() == $player) {
                return $rank;
            }
        }

        return 0;
    }
}
