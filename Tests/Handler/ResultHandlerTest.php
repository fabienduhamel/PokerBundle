<?php

namespace Fduh\PokerBundle\Tests\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Fduh\PokerBundle\Handler\ResultHandler;
use Mockery as m;

class ResultHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResultHandler
     */
    private $resultHandler;

    /**
     * @var PlayerManager
     */
    private $playerManager;

    public function setUp()
    {
        $player1 = m::mock('Fduh\PokerBundle\Entity\Player');
        $player2 = m::mock('Fduh\PokerBundle\Entity\Player');
        $players = new ArrayCollection(array($player1, $player2));

        $eventData = m::mock('Fduh\PokerBundle\Handler\Data\EventDataInterface');
        $eventData->shouldReceive('getPresentPlayers')->twice()->andReturn($players);

        $eventManager = m::mock('Fduh\PokerBundle\Handler\Data\EventManagerInterface');
        $eventManager->shouldReceive('addEvent')->twice()->andReturn(null);
        $eventManager->shouldReceive('getEventData')->twice()->andReturn($eventData);

        $this->playerManager = m::mock('Fduh\PokerBundle\Handler\Data\PlayerManagerInterface');
        $this->playerManager->shouldReceive('addEventData')->twice();

        $this->resultHandler = new ResultHandler($eventManager, $this->playerManager);
    }

    public function testResultHandlerWithEventsDoesNotAddSeason()
    {
        $event1 = m::mock('Fduh\PokerBundle\Entity\Event');
        $event2 = m::mock('Fduh\PokerBundle\Entity\Event');
        $events = new ArrayCollection(array($event1, $event2));

        $this->resultHandler->addEvents($events);
        $this->assertNull($this->resultHandler->getSeason());
    }

    public function testResultHandlerHydratesEventAndPlayerManager()
    {
        $event1 = m::mock('Fduh\PokerBundle\Entity\Event');
        $event2 = m::mock('Fduh\PokerBundle\Entity\Event');
        $events = new ArrayCollection(array($event1, $event2));

        $this->resultHandler->addEvents($events);
        // 2 events with 2 players = 4 calls
        $this->playerManager->shouldHaveReceived('addEventData')->times(4);
    }

    public function testResultHandlerHydratesPlayerManagerWhenAddingSeason()
    {
        $event1 = m::mock('Fduh\PokerBundle\Entity\Event');
        $event2 = m::mock('Fduh\PokerBundle\Entity\Event');
        $events = new ArrayCollection(array($event1, $event2));

        $season = m::mock('Fduh\PokerBundle\Entity\Season');
        $season->shouldReceive('getEvents')->once()->andReturn($events);

        $this->resultHandler->setSeason($season);
        // 2 events with 2 players = 4 calls
        $this->playerManager->shouldHaveReceived('addEventData')->times(4);
        $this->assertEquals($season, $this->resultHandler->getSeason());
    }
}
