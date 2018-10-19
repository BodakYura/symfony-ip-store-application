<?php

namespace bodakyuriy\IPStorageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ip_storage', 'array');

        $rootNode
            ->children()
            ->scalarNode('driver')->end()
            ->scalarNode('validator')->end()
            ->scalarNode('table_name')->end() // twitter
        ;

        return $treeBuilder;
    }
}
