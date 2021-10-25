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
        $treeBuilder = new TreeBuilder('vlabs_notification');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('config')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('root_namespace')
                            ->defaultValue('AppBundle\Notification')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('swiftmailer')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('default_from_email')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('default_from_name')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('mailer')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('default_from_email')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('default_from_name')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('push')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('gcm')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('sms')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('app_key')->end()
                        ->scalarNode('app_secret')->end()
                        ->scalarNode('consumer_key')->end()
                        ->booleanNode('disable_sending')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('slack')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('app_endpoint')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}