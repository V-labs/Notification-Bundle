<?php

namespace Vlabs\NotificationBundle;

use Vlabs\NotificationBundle\DependencyInjection\Compiler\NotifierPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class VlabsNotificationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new NotifierPass());
    }
}
