<?php

namespace Fduh\PokerBundle\Tests\Handler\Data;

use Fduh\PokerBundle\Handler\Data\LastHand;

class LastHandTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFirstTwoCardsOfAnEventLastHand()
    {
        $lastHand = new LastHand('AsAd Kh4c9s6dTd KdJh');
        $expectedCards = array('As', 'Ad');
        $this->assertEquals($expectedCards, $lastHand->getFirstTwoCards());
    }

    public function testGetSecondTwoCardsOfAnEventLastHand()
    {
        $lastHand = new LastHand('AsAd Kh4c9s6dTd KdJh');
        $expectedCards = array('Kd', 'Jh');
        $this->assertEquals($expectedCards, $lastHand->getSecondTwoCards());
    }

    public function testGetBoardCardsTest()
    {
        $lastHand = new LastHand('AsAd Kh4c9s6dTd KdJh');
        $expectedCards = array('Kh', '4c', '9s', '6d', 'Td');
        $this->assertEquals($expectedCards, $lastHand->getBoardCards());
    }
}
