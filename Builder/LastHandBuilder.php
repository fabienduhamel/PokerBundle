<?php

namespace Fduh\PokerBundle\Builder;

use Fduh\PokerBundle\Entity\Event;
use Fduh\PokerBundle\Handler\Data\LastHand;

/**
 * Provides builder of LastHand.
 */
class LastHandBuilder
{
    /**
     * @param Event $event
     * @return LastHand
     */
    public function build(Event $event)
    {
        return new LastHand($event->getLastHand());
    }
}
