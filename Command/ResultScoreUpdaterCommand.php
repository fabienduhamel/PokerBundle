<?php

namespace Fduh\PokerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Updates all results with their respective scores.
 */
class ResultScoreUpdaterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('poker:update-scores')
            ->setDescription('Updates results scores');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scoreCalculator = $this->getContainer()->get('poker.score_calculator');
        $em = $this->getContainer()->get('doctrine')->getManager();
        $results = $em->getRepository('FduhPokerBundle:Result')->findAll();
        foreach ($results as $result) {
            $result->setScore($scoreCalculator->calculateScore($result));
            $em->persist($result);
        }
        $em->flush();
        $output->writeln(sprintf("%d Results updated.", count($results)));
    }
}
