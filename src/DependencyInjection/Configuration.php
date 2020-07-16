<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /** @noinspection NullPointerExceptionInspection */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('lsv_simplemde');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->booleanNode('enable')->defaultTrue()->end()
                ->booleanNode('auto_download_font_awesome')->defaultNull()->end()
                ->integerNode('autosave_delay')->defaultNull()->end()
                ->scalarNode('blockstyles_bold')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
