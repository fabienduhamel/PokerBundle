<?php

namespace Fduh\PokerBundle\Tests\Handler\Data;

use Fduh\PokerBundle\Handler\Data\EventManager;
use Mockery as m;

class EventManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var Event
     */
    private $event1;

    /**
     * @var Event
     */
    private $event2;

    public function setUp()
    {
        $this->event1 = m::mock('Fduh\PokerBundle\Entity\Event');
        $this->event1->shouldReceive('getLastHand')->once()->andReturn(null);
        $this->event1->shouldReceive('getId')->once()->andReturn(1);
        $this->event2 = m::mock('Fduh\PokerBundle\Entity\Event');
        $this->event2->shouldReceive('getLastHand')->once()->andReturn(null);
        $this->event2->shouldReceive('getId')->once()->andReturn(2);
        $eventData = m::mock('Fduh\PokerBundle\Handler\Data\EventData');
        $eventData->shouldReceive('getMaximalScore')->twice()->andReturn(50);

        $eventDataBuilder = m::mock('Fduh\PokerBundle\Builder\EventDataBuilder');
        $eventDataBuilder->shouldReceive('build')->twice()->andReturn($eventData);

        $this->eventManager = new EventManager($eventDataBuilder);
    }

    public function testAddDifferentEventsCorrectlyUpdatesEventsData()
    {
        $this->eventManager->addEvent($this->event1);
        $this->eventManager->addEvent($this->event2);

        $this->assertEquals(2, $this->eventManager->getEventsData()->count());
    }

    public function testAddIdenticalEventsDoesNotStack()
    {
        $this->eventManager->addEvent($this->event1);
        $this->eventManager->addEvent($this->event1);

        $this->assertEquals(1, $this->eventManager->getEventsData()->count());
    }

    public function testGetMaximalScoreIsSumOfMaximalEventScores()
    {
        $this->eventManager->addEvent($this->event1);
        $this->eventManager->addEvent($this->event2);

        $this->assertEquals(100, $this->eventManager->getMaximalScore());
    }
}
