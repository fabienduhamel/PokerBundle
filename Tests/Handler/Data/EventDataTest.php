<?php

namespace Fduh\PokerBundle\Tests\Handler\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Fduh\PokerBundle\Entity\Event;
use Fduh\PokerBundle\Handler\Data\EventData;
use \Mockery as m;

class EventDataTest extends \PHPUnit_Framework_TestCase
{
    public function testEventDataHasAnEventWithoutLastHand()
    {
        $event = new Event();
        $scoreCalculator = m::mock('Fduh\PokerBundle\Calculator\ScoreCalculator');
        $eventData = new EventData($event, $scoreCalculator);

        $this->assertEquals($event, $eventData->getEvent());
        $this->assertNull($eventData->getLastHand());
    }

    public function testEventDataHasALastHand()
    {
        $event = new Event();
        $event->setLastHand('AhAd JdTd7c8s2d KhKc');
        $scoreCalculator = m::mock('Fduh\PokerBundle\Calculator\ScoreCalculator');
        $eventData = new EventData($event, $scoreCalculator);

        $this->assertEquals($event, $eventData->getEvent());
        $this->assertNotNull($eventData->getLastHand());
    }

    public function testEventDataHasPresentPlayersOfEvent()
    {
        $player1 = m::mock('Fduh\PokerBundle\Entity\Player');
        $player2 = m::mock('Fduh\PokerBundle\Entity\Player');

        $result1 = m::mock('Fduh\PokerBundle\Entity\Result');
        $result1->shouldReceive('getPlayer')->once()->andReturn($player1);
        $result2 = m::mock('Fduh\PokerBundle\Entity\Result');
        $result2->shouldReceive('getPlayer')->once()->andReturn($player2);
        $results = new ArrayCollection(array($result1, $result2));

        $event = m::mock('Fduh\PokerBundle\Entity\Event');
        $event->shouldReceive('getResults')->once()->andReturn($results);
        $event->shouldReceive('getLastHand')->once()->andReturn(null);
        $scoreCalculator = m::mock('Fduh\PokerBundle\Calculator\ScoreCalculator');
        $eventData = new EventData($event, $scoreCalculator);

        $this->assertEquals(2, $eventData->getPresentPlayers()->count());
    }

    public function testGetWinnerReturnsThePlayerWithFirstRank()
    {
        $player1 = m::mock('Fduh\PokerBundle\Entity\Player');
        $player2 = m::mock('Fduh\PokerBundle\Entity\Player');

        $result1 = m::mock('Fduh\PokerBundle\Entity\Result');
        $result1->shouldReceive('getPlayer')->once()->andReturn($player1);
        $result1->shouldReceive('getRank')->once()->andReturn(1);
        $result2 = m::mock('Fduh\PokerBundle\Entity\Result');
        $result2->shouldReceive('getPlayer')->once()->andReturn($player2);
        $result2->shouldReceive('getRank')->once()->andReturn(2);
        $results = new ArrayCollection(array($result1, $result2));

        $event = m::mock('Fduh\PokerBundle\Entity\Event');
        $event->shouldReceive('getResults')->once()->andReturn($results);
        $event->shouldReceive('getLastHand')->once()->andReturn(null);
        $scoreCalculator = m::mock('Fduh\PokerBundle\Calculator\ScoreCalculator');
        $eventData = new EventData($event, $scoreCalculator);

        $this->assertEquals($player1, $eventData->getWinner());
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetWinnerThrowsExceptionIfNoWinner()
    {
        $player1 = m::mock('Fduh\PokerBundle\Entity\Player');
        $player2 = m::mock('Fduh\PokerBundle\Entity\Player');

        $result1 = m::mock('Fduh\PokerBundle\Entity\Result');
        $result1->shouldReceive('getPlayer')->once()->andReturn($player1);
        $result1->shouldReceive('getRank')->once()->andReturn(3);
        $result2 = m::mock('Fduh\PokerBundle\Entity\Result');
        $result2->shouldReceive('getPlayer')->once()->andReturn($player2);
        $result2->shouldReceive('getRank')->once()->andReturn(2);
        $results = new ArrayCollection(array($result1, $result2));

        $event = m::mock('Fduh\PokerBundle\Entity\Event');
        $event->shouldReceive('getResults')->once()->andReturn($results);
        $event->shouldReceive('getLastHand')->once()->andReturn(null);
        $scoreCalculator = m::mock('Fduh\PokerBundle\Calculator\ScoreCalculator');
        $eventData = new EventData($event, $scoreCalculator);

        $eventData->getWinner();
    }
}
