<?php

namespace Fduh\PokerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fduh\PokerBundle\Entity\Result.
 *
 * @ORM\Table("Poker_Result")
 * @ORM\Entity(repositoryClass="Fduh\PokerBundle\Entity\ResultRepository")
 */
class Result extends EntityBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @ORM\ManyToOne(targetEntity="Fduh\PokerBundle\Entity\Event", inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="Fduh\PokerBundle\Entity\Player", inversedBy="results")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $prize;

    public function __toString()
    {
        return $this->player . ': [' . $this->event . ', rank ' . $this->rank . ']';
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rank.
     *
     * @param integer $rank
     *
     * @return Result
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank.
     *
     * @return integer
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set event.
     *
     * @param Event $event
     *
     * @return Result
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set player.
     *
     * @param Player $player
     *
     * @return Result
     */
    public function setPlayer(Player $player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player.
     *
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return Result
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return mixed
     */
    public function getPrize()
    {
        return $this->prize;
    }

    /**
     * @param mixed $prize
     * @return Result
     */
    public function setPrize($prize)
    {
        $this->prize = $prize;

        return $this;
    }
}
