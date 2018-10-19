<?php

namespace bodakyuriy\IPStorageBundle\DependencyInjection\Compiler;

use bodakyuriy\IPStorageBundle\ValidatorChain;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ValidatorCompilerPass
 * @package bodakyuriy\IPStorageBundle\DependencyInjection\Compiler
 */
class ValidatorCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition(ValidatorChain::class)) {
            return;
        }

        $definition = $container->getDefinition(ValidatorChain::class)->setPublic(true);

        foreach ($container->findTaggedServiceIds('ip_storage.validator') as $id => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('addValidator', [new Reference($id), $attributes['alias']]);
            }
        }
    }
}