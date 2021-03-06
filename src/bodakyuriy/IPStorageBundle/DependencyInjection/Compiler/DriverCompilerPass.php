<?php

namespace bodakyuriy\IPStorageBundle\DependencyInjection\Compiler;

use bodakyuriy\IPStorageBundle\DriverChain;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class DriverCompilerPass
 * @package bodakyuriy\IPStorageBundle\DependencyInjection\Compiler
 */
class DriverCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition(DriverChain::class)) {
            return;
        }

        $definition = $container->getDefinition(DriverChain::class)->setPublic(true);

        foreach ($container->findTaggedServiceIds('ip_storage.driver') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addDriver', [new Reference($id), $attributes['alias']]);
            }
        }
    }
}