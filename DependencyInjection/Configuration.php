<?php

namespace Vlabs\NotificationBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('vlabs_notification');

        $rootNode
            ->children()
                ->arrayNode('push')
                    ->children()
                        ->booleanNode('gcm')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('sms')
                    ->children()
                        ->scalarNode('app_key')->end()
                        ->scalarNode('app_secret')->end()
                        ->scalarNode('consumer_key')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}