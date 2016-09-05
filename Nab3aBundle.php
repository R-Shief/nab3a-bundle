<?php

namespace RShief\Nab3aBundle;

use RShief\Nab3aBundle\Console\AddConsoleCommandPass;
use RShief\Nab3aBundle\DependencyInjection\Compiler\AttachPluginsCompilerPass;
use RShief\Nab3aBundle\DependencyInjection\Nab3aExtension;
use RShief\Nab3aBundle\Guzzle\StackMiddlewareCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Nab3aBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new StackMiddlewareCompilerPass());
        $container->addCompilerPass(new AddConsoleCommandPass());
        $container->addCompilerPass(new AttachPluginsCompilerPass(EventLoop\Configurator::class, 'event_loop.plugin', 'nab3a.event_loop'), PassConfig::TYPE_BEFORE_REMOVING);
        $container->addCompilerPass(new AttachPluginsCompilerPass(Evenement\Configurator::class, 'evenement.plugin'), PassConfig::TYPE_BEFORE_REMOVING);
    }

    public function getContainerExtension()
    {
        return new Nab3aExtension();
    }
}
