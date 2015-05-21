<?php

namespace Fduh\PokerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fduh_poker');

        $rootNode
            ->children()
                ->scalarNode('calculation_class')
                ->defaultValue('Fduh\PokerBundle\Calculator\Method1CalculatorStrategy')
                ->info('The class used to calculate scores.')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
