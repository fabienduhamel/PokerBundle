<?php

namespace Fduh\PokerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fduh\PokerBundle\Entity\Event.
 *
 * @ORM\Table("Poker_Event")
 * @ORM\Entity(repositoryClass="Fduh\PokerBundle\Entity\EventRepository")
 */
class Event extends EntityBase
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Fduh\PokerBundle\Entity\Season", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $season;

    /**
     * @ORM\OneToMany(targetEntity="Fduh\PokerBundle\Entity\Result", mappedBy="event", cascade={"remove","persist"})
     */
    private $results;

    /**
     * @var string
     *
     * @ORM\Column(name="last_hand", type="string", length=255, nullable=true)
     */
    private $lastHand;

    /**
     * @var boolean
     *
     * @ORM\Column(name="viewable", type="boolean", nullable=true)
     */
    private $viewable;

    public function __construct()
    {
        parent::__construct();
        $this->date = new \Datetime();
        $this->results = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->date->format('d-m-Y');
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
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add result.
     *
     * @param Result $result
     *
     * @return Event
     */
    public function addResult(Result $result)
    {
        $this->results[] = $result;
        $result->setEvent($this);

        return $this;
    }

    /**
     * Remove result.
     *
     * @param Result $result
     */
    public function removeResult(Result $result)
    {
        $this->results->removeElement($result);
    }

    /**
     * Get results.
     *
     * @return Collection
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set season.
     *
     * @param Season $season
     *
     * @return Event
     */
    public function setSeason(Season $season)
    {
        $this->season = $season;

        return $this;
    }

    /**
     * Get season.
     *
     * @return Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set lastHand.
     *
     * @param string $lastHand
     *
     * @return Event
     */
    public function setLastHand($lastHand)
    {
        $this->lastHand = $lastHand;

        return $this;
    }

    /**
     * Get lastHand.
     *
     * @return string
     */
    public function getLastHand()
    {
        return $this->lastHand;
    }

    /**
     * Set viewable.
     *
     * @param boolean $viewable
     *
     * @return Post
     */
    public function setViewable($viewable)
    {
        $this->viewable = $viewable;

        return $this;
    }

    /**
     * Get viewable.
     *
     * @return boolean
     */
    public function getViewable()
    {
        return $this->viewable;
    }
}
