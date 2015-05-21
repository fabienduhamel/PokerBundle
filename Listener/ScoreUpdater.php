<?php

namespace Fduh\PokerBundle\Listener;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Fduh\PokerBundle\Calculator\ScoreCalculatorInterface;
use Fduh\PokerBundle\Entity\Result;

class ScoreUpdater
{
    /**
     * @var ScoreCalculatorInterface
     */
    private $scoreCalculator;

    /**
     * @param ScoreCalculatorInterface $scoreCalculator
     */
    public function __construct(ScoreCalculatorInterface $scoreCalculator)
    {
        $this->scoreCalculator = $scoreCalculator;
    }

    /**
     * Adds a score by default to not crash the process (score not asked in admin form).
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Result) {
            $entity->setScore(1);
        }
    }

    /**
     * @param OnFlushEventArgs $eventArgs
     */
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof Result) {
                $event = $entity->getEvent();
                // Adds the result to the event to recalculate the scores.
                $event->addResult($entity);
                $results = $event->getResults();
                $this->updateScores($results, $em);
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Result) {
                $results = $entity->getEvent()->getResults();
                $this->updateScores($results, $em);
            }
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof Result) {
                $results = $entity->getEvent()->getResults();
                // Finds the future removed element and removes it from the results to recalculate the scores.
                foreach ($results as $key => $result) {
                    if ($entity == $result) {
                        $results->remove($key);
                        break;
                    }
                }

                $this->updateScores($results, $em);
            }
        }
    }

    /**
     * Updates the scores of each result in $results.
     *
     * @param Collection    $results
     * @param EntityManager $em
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \Exception
     */
    private function updateScores(Collection $results, EntityManager $em)
    {
        $uow = $em->getUnitOfWork();

        foreach ($results as $result) {
            $result->setScore($this->scoreCalculator->calculateScore($result));
            $em->persist($result);
            $uow->recomputeSingleEntityChangeSet(
                $em->getMetadataFactory()->getMetadataFor('Fduh\PokerBundle\Entity\Result'),
                $result
            );
        }
    }
}
