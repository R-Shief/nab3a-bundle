<?php

namespace RShief\Nab3aBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AttachPluginsCompilerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $configuratorService;

    /**
     * @var string
     */
    private $pluginTag;
    /**
     * @var string
     */
    private $defaultServiceId;

    /**
     * AttachPluginsCompilerPass constructor.
     *
     * @param string $configuratorService
     * @param string $pluginTag
     * @param string $defaultServiceId
     */
    public function __construct($configuratorService, $pluginTag, $defaultServiceId = null)
    {
        $this->configuratorService = $configuratorService;
        $this->pluginTag = $pluginTag;
        $this->defaultServiceId = $defaultServiceId;
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $serviceIds = $container->findTaggedServiceIds($this->pluginTag);

        $configurators = [];
        foreach ($serviceIds as $serviceId => $tags) {
            foreach ($tags as $tag) {
                $configurators[isset($tag['id']) ? $tag['id'] : $this->defaultServiceId][] = $serviceId;
            }
        }

        foreach ($configurators as $forServiceId => $pluginIds) {
            $emitterDefinition = $container->findDefinition($forServiceId);

            if (!$emitterDefinition->getConfigurator()) {
                $configuratorDefinition = new Definition($this->configuratorService, [
                  array_map(function ($id) {
                      return new Reference($id);
                  }, $pluginIds),
                ]);
                $emitterDefinition->setConfigurator([$configuratorDefinition, 'configure']);
            }
        }
    }
}
