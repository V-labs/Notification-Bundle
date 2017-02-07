<?php

namespace Vlabs\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class NotifierPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('vlabs_notification.notifier.resolver')) {
            return;
        }

        $definition = $container->findDefinition('vlabs_notification.notifier.resolver');
        $taggedServices = $container->findTaggedServiceIds('vlabs_notification.notifier');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addNotifier', [new Reference($id)]);
        }
    }
}