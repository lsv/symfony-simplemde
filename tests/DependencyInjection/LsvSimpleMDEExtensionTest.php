<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundleTest\DependencyInjection;

use Lsv\SimpleMDEBundle\DependencyInjection\LsvSimpleMDEExtension;
use Lsv\SimpleMDEBundle\Form\Type\SimpleMDEType;
use Lsv\SimpleMDEBundle\Twig\LsvSimpleMDETwigExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class LsvSimpleMDEExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @test
     */
    public function hasTwigExtension(): void
    {
        $this->container->setParameter('kernel.bundles', []);
        $this->load();

        $taggedServices = $this->container->findTaggedServiceIds('twig.extension');
        self::assertArrayHasKey(LsvSimpleMDETwigExtension::class, $taggedServices);
    }

    /**
     * @test
     */
    public function hasFormType(): void
    {
        $this->container->setParameter('kernel.bundles', []);
        $this->load();

        $taggedServices = $this->container->findTaggedServiceIds('form.type');
        self::assertArrayHasKey(SimpleMDEType::class, $taggedServices);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new LsvSimpleMDEExtension(),
        ];
    }
}
