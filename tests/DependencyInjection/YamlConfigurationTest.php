<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundleTest\DependencyInjection;

use Lsv\SimpleMDEBundle\DependencyInjection\Configuration;
use Lsv\SimpleMDEBundle\DependencyInjection\LsvSimpleMDEExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class YamlConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    /**
     * @test
     */
    public function canDisableByYamlConfiguration(): void
    {
        $expected = array_merge(
            [
                'auto_download_font_awesome' => null,
                'autosave_delay' => null,
                'blockstyles_bold' => null,
            ],
            ['enable' => false]
        );
        $sources = [
            __DIR__.'/../Fixtures/config/disable.yaml',
        ];
        $this->assertProcessedConfigurationEquals($expected, $sources);
    }

    /**
     * @return LsvSimpleMDEExtension
     */
    protected function getContainerExtension(): ExtensionInterface
    {
        return new LsvSimpleMDEExtension();
    }

    /**
     * @return Configuration
     */
    protected function getConfiguration(): ConfigurationInterface
    {
        return new Configuration();
    }
}
