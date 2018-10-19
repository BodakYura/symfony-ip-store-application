<?php

namespace bodakyuriy\IPStorageBundle;

use bodakyuriy\IPStorageBundle\DependencyInjection\Compiler\DriverCompilerPass;
use bodakyuriy\IPStorageBundle\DependencyInjection\Compiler\ValidatorCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class IPStorageBundle
 * @package bodakyuriy\IPStorageBundle
 */
class IPStorageBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DriverCompilerPass());
        $container->addCompilerPass(new ValidatorCompilerPass());
    }
}
