<?php

namespace Fduh\PokerBundle\Tests\Handler\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Fduh\PokerBundle\Handler\Data\PlayerData;
use Mockery as m;

class PlayerDataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PlayerData
     */
    private $playerData;

    public function setUp()
    {
        $player = m::mock('Fduh\PokerBundle\Entity\Player');
        $this->playerData = new PlayerData($player);
    }

    /**
     * @return EventDataInterface an event data with a won event
     */
    private function getWonEventData()
    {
        $wonEvent = m::mock('Fduh\PokerBundle\Entity\Event');
        $wonEvent->shouldReceive('getId')->once()->andReturn(2);

        $wonResult = m::mock('Fduh\PokerBundle\Entity\Result');
        $wonResult->shouldReceive('getRank')->once()->andReturn(1);
        $wonResult->shouldReceive('getScore')->once()->andReturn(100);
        $wonResult->shouldReceive('getEvent')->once()->andReturn($wonEvent);

        $wonEventData = m::mock('Fduh\PokerBundle\Handler\Data\EventDataInterface');
        $wonEventData->shouldReceive('getEvent')->once()->andReturn($wonEvent);
        $wonEventData->shouldReceive('getResult')->once()->andReturn($wonResult);
        $wonEventData->shouldReceive('getMaximalScore')->once()->andReturn(100);

        return $wonEventData;
    }

    /**
     * @return EventDataInterface an event data with a lost event
     */
    private function getLostEventData()
    {
        $lostEvent = m::mock('Fduh\PokerBundle\Entity\Event');
        $lostEvent->shouldReceive('getId')->once()->andReturn(1);

        $lostResult = m::mock('Fduh\PokerBundle\Entity\Result');
        $lostResult->shouldReceive('getRank')->once()->andReturn(3);
        $lostResult->shouldReceive('getScore')->once()->andReturn(20);
        $lostResult->shouldReceive('getEvent')->once()->andReturn($lostEvent);

        $lostEventData = m::mock('Fduh\PokerBundle\Handler\Data\EventDataInterface');
        $lostEventData->shouldReceive('getEvent')->once()->andReturn($lostEvent);
        $lostEventData->shouldReceive('getResult')->once()->andReturn($lostResult);
        $lostEventData->shouldReceive('getMaximalScore')->once()->andReturn(80);

        return $lostEventData;
    }

    /**
     * @return EventDataInterface an event data without result (player not present)
     */
    private function getNoResultEventData()
    {
        $noResultEvent = m::mock('Fduh\PokerBundle\Entity\Event');
        $noResultEvent->shouldReceive('getId')->once()->andReturn(1);

        $NoResultEventData = m::mock('Fduh\PokerBundle\Handler\Data\EventDataInterface');
        $NoResultEventData->shouldReceive('getEvent')->once()->andReturn($noResultEvent);
        $NoResultEventData->shouldReceive('getResult')->once()->andReturn(null);
        $NoResultEventData->shouldReceive('getMaximalScore')->once()->andReturn(80);

        return $NoResultEventData;
    }

    public function testAddEventDataSetsEventsDataAndResults()
    {
        $lostEventData = $this->getLostEventData();
        $lostEvent = $lostEventData->getEvent();
        $wonEventData = $this->getWonEventData();
        $wonEvent = $wonEventData->getEvent();

        $this->playerData->addEventData($lostEventData);
        $this->playerData->addEventData($wonEventData);
        $expectedPlayedEvents = new ArrayCollection(array($lostEvent, $wonEvent));
        $this->assertEquals($expectedPlayedEvents, $this->playerData->getPlayedEvents());
        $this->assertEquals(20, $this->playerData->getScore($lostEvent));
        $this->assertEquals(120, $this->playerData->getTotal());
        $this->assertEquals(3, $this->playerData->getRank($lostEvent));
        $this->assertEquals(1, $this->playerData->getRank($wonEvent));
        $this->assertEquals(50, $this->playerData->getWinRate());
        $this->assertEquals(60, $this->playerData->getAveragePointsPerEvent());
        $this->assertEquals(180, $this->playerData->getMaximalTotal());
        $this->assertEquals(1, $this->playerData->getNumberOfPlaces(1));
        $this->assertEquals(1, $this->playerData->getNumberOfPlaces(3));
        $this->assertEquals(0, $this->playerData->getNumberOfPlaces(8));
        $this->assertEquals(3, $this->playerData->getWorstPlace());
    }

    public function testAddEventDataDoesNotUpdateTotalIfNoResultForPlayer()
    {
        $noResultEventData = $this->getNoResultEventData();
        $noResultEvent = $noResultEventData->getEvent();
        $wonEventData = $this->getWonEventData();
        $wonEvent = $wonEventData->getEvent();

        $this->playerData->addEventData($noResultEventData);
        $this->playerData->addEventData($wonEventData);
        $this->assertEquals(0, $this->playerData->getScore($noResultEvent));
        $this->assertEquals(100, $this->playerData->getScore($wonEvent));
        $this->assertEquals(100, $this->playerData->getTotal());
        $this->assertEquals(0, $this->playerData->getRank($noResultEvent));
        $this->assertEquals(1, $this->playerData->getRank($wonEvent));

        $expectedWonEvents = new ArrayCollection(array($wonEvent));
        $this->assertEquals($expectedWonEvents, $this->playerData->getWonEvents());
        $this->assertEquals(100, $this->playerData->getWinRate());
        $this->assertEquals(100, $this->playerData->getAveragePointsPerEvent());
        $this->assertEquals(100, $this->playerData->getMaximalTotal());
        $this->assertEquals(1, $this->playerData->getNumberOfPlaces(1));
        $this->assertEquals(0, $this->playerData->getNumberOfPlaces(3));
        $this->assertEquals(1, $this->playerData->getWorstPlace());
    }


}
