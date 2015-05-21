<?php

namespace Fduh\PokerBundle\Chart;

use Fduh\PokerBundle\Entity\Season;
use Fduh\PokerBundle\Handler\Data\PlayerData;
use Fduh\PokerBundle\Handler\ResultHandler;
use SaadTazi\GChartBundle\DataTable\DataColumn;
use SaadTazi\GChartBundle\DataTable\DataRow;
use SaadTazi\GChartBundle\DataTable\DataTable;

/**
 * Gives google chart for poker results.
 */
class ChartMaker
{

    /**
     * @var ResultHandler containing useful data to create the chart.
     */
    private $resultsHandler;

    /**
     * @param ResultHandler $resultsHandler
     */
    public function __construct(ResultHandler $resultsHandler)
    {
        $this->resultsHandler = $resultsHandler;
    }

    /**
     * @param Season $season
     */
    public function setSeason(Season $season)
    {
        $this->resultsHandler->setSeason($season);
    }

    /**
     * @param $events
     */
    public function setEvents($events)
    {
        $this->resultsHandler->addEvents($events);
    }

    /**
     * @return DataTable
     */
    public function getChart()
    {
        $playerManager = $this->resultsHandler->getPlayerManager();
        $playersData = $playerManager->getPlayersData();

        // retrieves players list
        $chart = new DataTable();
        $chart->addColumn('id1', 'label 1', 'string');
        foreach ($playersData as $playerData) {
            $player = $playerData->getPlayer();
            $chart->addColumnObject(
                new DataColumn(
                    'id' . $player->getId(),
                    $player->getName() . " (" . $playerData->getTotal() . ")",
                    'number'
                )
            );
        }

        // retrieves scores by player
        $results = array();
        foreach ($playersData as $playerData) {
            $player = $playerData->getPlayer();
            $results[$player->getId()] = $this->getScoreEvolution($playerData);
        }

        // retrieves event scores
        $eventIndex = 0;
        foreach ($this->resultsHandler->getEventManager()->getEventsData() as $eventData) {
            $event = $eventData->getEvent();
            $rowValues = array();
            $rowValues[] = $event->getDate()->format('d M Y');
            foreach ($playersData as $playerData) {
                $player = $playerData->getPlayer();
                $rowValues[] = $results[$player->getId()][$event->getId()];
            }

            $dataRow = new DataRow($rowValues);
            $chart->addRowObject($dataRow);
            $eventIndex++;
        }

        return $chart;
    }

    /**
     * @return int the width of the chart
     */
    public function getWidth()
    {
        return 900;
    }

    /**
     * @return int the height of the chart
     */
    public function getHeight()
    {
        return 700;
    }

    /**
     * @param PlayerData $playerData
     * @return array of scores incrementing among all existing events
     */
    private function getScoreEvolution(PlayerData $playerData)
    {
        $subTotal = 0;
        $scoreEvolution = array();

        $eventsData = $this->resultsHandler->getEventManager()->getEventsData();
        foreach ($eventsData as $eventData) {
            $event = $eventData->getEvent();
            $subTotal += $playerData->getScore($event);
            $scoreEvolution[$event->getId()] = $subTotal;
        }

        return $scoreEvolution;
    }
}
