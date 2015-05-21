<?php

namespace Fduh\PokerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Fduh\PokerBundle\Entity\Player.
 *
 * @ORM\Table("Poker_Player")
 * @ORM\Entity(repositoryClass="Fduh\PokerBundle\Entity\PlayerRepository")
 */
class Player extends EntityBase
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, unique=true, nullable=true)
     */
    private $picture;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="player", cascade={"remove","persist"})
     */
    private $results;

    public function __construct()
    {
        parent::__construct();
        $this->results = new ArrayCollection();
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
     * Set name.
     *
     * @param string $name
     *
     * @return Player
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
     * Set picture.
     *
     * @param string $picture
     *
     * @return Player
     */
    public function setPicture($picture)
    {
        // delete old picture
        if ($this->picture) {
            unlink($this->getPictureAbsolutePath());
        }
        $newPictureFileString = $this->getId()."-".$picture->getClientOriginalName();
        copy($picture->getPathName(), $this->getUploadRootDir().DIRECTORY_SEPARATOR.$newPictureFileString);
        $this->picture = $newPictureFileString;

        return $this;
    }

    /**
     * Get picture.
     *
     * @return string
     */
    public function getPicture()
    {
        if ($this->picture) {
            return $this->getUploadDir().DIRECTORY_SEPARATOR.$this->picture;
        }

        return;
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
     * Add results.
     *
     * @param Result $results
     *
     * @return Player
     */
    public function addResult(Result $results)
    {
        $this->results[] = $results;

        return $this;
    }

    /**
     * Remove results.
     *
     * @param Result $results
     */
    public function removeResult(Result $results)
    {
        $this->results->removeElement($results);
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

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getPictureAbsolutePath()
    {
        if ($this->picture) {
            return $this->getUploadRootDir().DIRECTORY_SEPARATOR.$this->picture;
        }

        return;
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/players_pictures';
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Player
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
