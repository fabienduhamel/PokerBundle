<?php

namespace Fduh\PokerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Fduh\PokerBundle\Entity\Season.
 *
 * @ORM\Table("Poker_Season")
 * @ORM\Entity(repositoryClass="Fduh\PokerBundle\Entity\SeasonRepository")
 */
class Season extends EntityBase
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", unique=true)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var boolean
     *
     * @ORM\Column(name="finished", type="boolean", nullable=true)
     */
    private $finished;

    /**
     * @ORM\OneToMany(targetEntity="Fduh\PokerBundle\Entity\Event", mappedBy="season", cascade={"remove","persist"})
     */
    private $events;

    public function __toString()
    {
        return $this->name;
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
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->events = new ArrayCollection();
        $this->finished = false;
    }

    /**
     * Add events.
     *
     * @param Event $events
     *
     * @return Season
     */
    public function addEvent(Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events.
     *
     * @param Event $events
     */
    public function removeEvent(Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events.
     *
     * @return Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Season
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Season
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Set finished
     *
     * @param boolean $finished
     * @return Season
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return boolean
     */
    public function getFinished()
    {
        return $this->finished;
    }
}
