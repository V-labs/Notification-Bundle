<?php

namespace Vlabs\NotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Vlabs\NotificationBundle\Notifier\OvhSmsNotifier;
use Vlabs\NotificationBundle\Notifier\RmsPushNotifier;
use Vlabs\NotificationBundle\Notifier\SlackNotifier;
use Vlabs\NotificationBundle\Notifier\SwiftMailerNotifier;

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

        if (isset($config['swiftmailer']) && $config['swiftmailer']['enabled'] === true) {
            if (!$container->has('vlabs_notification.notifier.swift_mailer')) {
                $container
                    ->register('vlabs_notification.notifier.swift_mailer', SwiftMailerNotifier::class)
                    ->addArgument(new Reference('mailer'))
                    ->addArgument($config['swiftmailer']['default_from_email'])
                    ->addArgument($config['swiftmailer']['default_from_name'])
                    ->addTag('vlabs_notification.notifier')
                ;
            }
        }

        if (isset($config['push']) && $config['push']['enabled'] === true) {
            if (!$container->has('vlabs_notification.notifier.rms_push')) {
                $container
                    ->register('vlabs_notification.notifier.rms_push', RmsPushNotifier::class)
                    ->addArgument(new Reference('rms_push_notifications'))
                    ->addTag('vlabs_notification.notifier')
                ;
            }

            /** @var Definition $definition */
            $definition = $container->findDefinition('vlabs_notification.notifier.rms_push');
            $definition->addMethodCall('setConfig', [$config['push']]);
        }

        if (isset($config['sms']) && $config['sms']['enabled'] === true) {
            if (!$container->has('vlabs_notification.notifier.ovh_sms')) {
                $container
                    ->register('vlabs_notification.notifier.ovh_sms', OvhSmsNotifier::class)
                    ->addTag('vlabs_notification.notifier')
                ;
            }

            /** @var Definition $definition */
            $definition = $container->findDefinition('vlabs_notification.notifier.ovh_sms');
            $definition->addMethodCall('setConfig', [$config['sms']]);
        }

        if (isset($config['slack']) && $config['slack']['enabled'] === true) {
            if (!$container->has('vlabs_notification.notifier.slack')) {
                $container
                    ->register('vlabs_notification.notifier.slack', SlackNotifier::class)
                    ->addTag('vlabs_notification.notifier')
                ;
            }

            /** @var Definition $definition */
            $definition = $container->findDefinition('vlabs_notification.notifier.slack');
            $definition->addMethodCall('setConfig', [$config['slack']]);
        }

        /** @var Definition $definition */
        $definition = $container->findDefinition('vlabs_notification.factory.message');
        $definition->replaceArgument(2, $config['config']['root_namespace']);
    }
}
