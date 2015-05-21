<?php

namespace Fduh\PokerBundle\Handler\Data;

/**
 * Represents an event last hand.
 */
class LastHand
{
    /**
     * @var array
     */
    private $firstTwoCards;

    /**
     * @var array
     */
    private $secondTwoCards;

    /**
     * @var array
     */
    private $boardCards;

    /**
     * @param string $lastHandString
     */
    public function __construct($lastHandString)
    {
        $cards = explode(' ', $lastHandString);
        $this->firstTwoCards = $this->extractCards($cards[0]);
        $this->secondTwoCards = $this->extractCards($cards[2]);
        $this->boardCards = $this->extractCards($cards[1]);
    }

    /**
     * @return array the first two cards of the last hands (handed by one player).
     */
    public function getFirstTwoCards()
    {
        return $this->firstTwoCards;
    }

    /**
     * @return array the first two cards of the last hands (handed by other player).
     */
    public function getSecondTwoCards()
    {
        return $this->secondTwoCards;
    }

    /**
     * @return array the board cards.
     */
    public function getBoardCards()
    {
        return $this->boardCards;
    }

    /**
     * @param $cardsString
     * @return array splitted last hand string in 2/5/2 cards group.
     */
    private function extractCards($cardsString)
    {
        $cards = array();
        $cardsStringLength = strlen($cardsString);
        $index = 0;
        while ($index < $cardsStringLength) {
            $cards[] = substr($cardsString, $index, 2);
            $index = $index + 2;
        }

        return $cards;
    }
}
