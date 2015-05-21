<?php

namespace Fduh\PokerBundle\Sorter;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Fduh\PokerBundle\Handler\Data\PlayerDataInterface;

/**
 * Manage sort of players data by their score.
 */
class PlayerDataSorter
{

    /**
     * @param Collection $playersData
     * @return ArrayCollection sorted $playerData by their total
     */
    public function sortByTotalDesc(Collection $playersData)
    {
        $playersDataArray = $playersData->toArray();
        uasort($playersDataArray, array($this, 'cmp'));

        return new ArrayCollection($playersDataArray);
    }

    /**
     * Inverted comparison.
     *
     * @param PlayerDataInterface $playerData1
     * @param PlayerDataInterface $playerData2
     * @return int
     */
    private function cmp(PlayerDataInterface $playerData1, PlayerDataInterface $playerData2)
    {
        if ($playerData1->getTotal() == $playerData2->getTotal()) {
            return 0;
        }

        return ($playerData1->getTotal() < $playerData2->getTotal()) ? 1 : -1;
    }
}
