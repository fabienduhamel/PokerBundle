<?php

namespace Fduh\PokerBundle\Tests\Calculator;

use Doctrine\Common\Collections\ArrayCollection;
use \Mockery as m;
use Fduh\PokerBundle\Calculator\Method1CalculatorStrategy;
use Fduh\PokerBundle\Calculator\ScoreCalculator;

class ScoreCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testScoreCalculatorUsesGivenStrategyToCalculateScore()
    {
        $method1Strategy = new Method1CalculatorStrategy();
        $scoreCalculator = new ScoreCalculator($method1Strategy);
        $result1 = m::mock('Fduh\PokerBundle\Entity\Result');
        $result2 = m::mock('Fduh\PokerBundle\Entity\Result');
        $event = m::mock('Fduh\PokerBundle\Entity\Event');
        $event->shouldReceive('getResults')->once()->andReturn(new ArrayCollection(array($result1, $result2)));
        $result1->shouldReceive('getEvent')->once()->andReturn($event);
        $result1->shouldReceive('getRank')->once()->andReturn(1);

        $expectedScore = $method1Strategy->calculate($result1->getRank(), 2);
        $this->assertEquals($expectedScore, $scoreCalculator->calculateScore($result1));
    }

    public function testScoreCalculatorMaximalScoreIsFirstRankedScore()
    {
        $method1Strategy = new Method1CalculatorStrategy();
        $scoreCalculator = new ScoreCalculator($method1Strategy);
        $rank1Score = $method1Strategy->calculate(1, 2);
        $event = m::mock('Fduh\PokerBundle\Entity\Event');
        $result1 = m::mock('Fduh\PokerBundle\Entity\Result');
        $result2 = m::mock('Fduh\PokerBundle\Entity\Result');
        $event->shouldReceive('getResults')->once()->andReturn(new ArrayCollection(array($result1, $result2)));
        $this->assertEquals($rank1Score, $scoreCalculator->getMaximalScore($event));
    }

}
