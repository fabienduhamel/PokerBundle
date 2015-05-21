<?php

namespace Fduh\PokerBundle\Tests\Handler\Data;

use Doctrine\Common\Collections\ArrayCollection;
use Fduh\PokerBundle\Handler\Data\PlayerManager;
use Fduh\PokerBundle\Sorter\PlayerDataSorter;
use Mockery as m;

class PlayerManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PlayerManager
     */
    private $playerManager;

    /**
     * @var Player
     */
    private $player1;

    /**
     * @var Player
     */
    private $player2;

    /**
     * @var PlayerData
     */
    private $playerData1;

    /**
     * @var PlayerData
     */
    private $playerData2;

    public function setUp()
    {
        $this->player1 = m::mock('Fduh\PokerBundle\Entity\Player');
        $this->player1->shouldReceive('getId')->zeroOrMoreTimes()->andReturn(1);
        $this->player2 = m::mock('Fduh\PokerBundle\Entity\Player');
        $this->player2->shouldReceive('getId')->zeroOrMoreTimes()->andReturn(2);

        $this->playerData1 = m::mock('Fduh\PokerBundle\Handler\Data\PlayerDataInterface');
        $this->playerData1->shouldReceive('addEventData')->once();
        $this->playerData1->shouldReceive('getTotal')->zeroOrMoreTimes()->andReturn(50);

        $this->playerData2 = m::mock('Fduh\PokerBundle\Handler\Data\PlayerDataInterface');
        $this->playerData2->shouldReceive('addEventData')->once();
        $this->playerData2->shouldReceive('getTotal')->zeroOrMoreTimes()->andReturn(100);

        $playerDataBuilder = m::mock('Fduh\PokerBundle\Builder\PlayerDataBuilder');
        $playerDataBuilder->shouldReceive('build')->once()->with($this->player1)->andReturn($this->playerData1);
        $playerDataBuilder->shouldReceive('build')->once()->with($this->player2)->andReturn($this->playerData2);

        $playerDataSorter = new PlayerDataSorter();
        $this->playerManager = new PlayerManager($playerDataBuilder, $playerDataSorter);
    }

    public function testAddEventDataUpdatesPlayersData()
    {
        $eventData1 = m::mock('Fduh\PokerBundle\Handler\Data\EventDataInterface');
        $eventData2 = m::mock('Fduh\PokerBundle\Handler\Data\EventDataInterface');
        $this->playerManager->addEventData($this->player1, $eventData1);
        $this->playerManager->addEventData($this->player2, $eventData2);

        $this->assertEquals(2, $this->playerManager->getPlayersData()->count());
        $this->assertEquals($this->playerData1, $this->playerManager->getPlayerData($this->player1));
    }
}
