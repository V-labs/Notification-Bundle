<?php

namespace Vlabs\NotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class VlabsNotificationExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if(isset($config['push']) && $container->has('vlabs_notification.notifier.rms_push'))
        {
            /** @var Definition $definition */
            $definition = $container->findDefinition('vlabs_notification.notifier.rms_push');
            $definition->addMethodCall('setConfig', $config['push']);
        }

        if(isset($config['sms']) && $container->has('vlabs_notification.notifier.ovh_sms'))
        {
            /** @var Definition $definition */
            $definition = $container->findDefinition('vlabs_notification.notifier.ovh_sms');
            //$definition->addMethodCall('setConfig', $config);
        }

        if(isset($config['slack']) && $container->has('vlabs_notification.notifier.slack'))
        {
            /** @var Definition $definition */
            $definition = $container->findDefinition('vlabs_notification.notifier.slack');
            $definition->addMethodCall('setConfig', [$config['slack']]);
        }
    }
}
