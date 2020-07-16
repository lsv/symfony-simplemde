<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundle\DependencyInjection;

use Lsv\SimpleMDEBundle\Configuration\FormConfiguration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class LsvSimpleMDEExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->getDefinition(FormConfiguration::class)
            ->setArgument(0, $mergedConfig);
    }

    public function getAlias(): string
    {
        return 'lsv_simplemde';
    }
}
