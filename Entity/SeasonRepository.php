<?php

namespace Fduh\PokerBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * SeasonRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SeasonRepository extends EntityRepository
{
    /**
     * @return Season the season with the most recent event
     */
    public function findLastSeason()
    {
        $seasons = $this->getEntityManager()
            ->createQuery(
                'SELECT s
                FROM FduhPokerBundle:Season s
                ORDER BY s.created_at DESC'
            )
            ->getResult();
        $season = $seasons[0];

        return $this->findSeasonBySlug($season->getSlug());
    }

    public function findSeasonBySlug($slug)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s, e, r, p FROM FduhPokerBundle:Season s
            JOIN s.events e
            JOIN e.results r
            JOIN r.player p
            WHERE s.slug = :slug'
            )
            ->setParameter('slug', $slug)
            ->getSingleResult();
    }
}
