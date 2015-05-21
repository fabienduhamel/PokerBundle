<?php

namespace Fduh\PokerBundle\Tests\Calculator;

use Fduh\PokerBundle\Calculator\Method1CalculatorStrategy;
use Fduh\PokerBundle\Calculator\Method2CalculatorStrategy;
use Mockery as m;

class CalculatorStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function testMethod1GivesMorePointsOnHigherRanks()
    {
        $method1Strategy = new Method1CalculatorStrategy();
        $rank1Score = $method1Strategy->calculate(1, 10);
        $rank2Score = $method1Strategy->calculate(2, 10);
        $this->assertTrue($rank1Score > $rank2Score);
    }

    public function testMethod2GivesMorePointsOnHigherRanks()
    {
        $method1Strategy = new Method2CalculatorStrategy();
        $rank1Score = $method1Strategy->calculate(1, 10);
        $rank2Score = $method1Strategy->calculate(2, 10);
        $this->assertTrue($rank1Score > $rank2Score);
    }
}
