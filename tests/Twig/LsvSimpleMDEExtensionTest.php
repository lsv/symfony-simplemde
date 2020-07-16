<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundleTest\Twig;

use Lsv\SimpleMDEBundle\Configuration\FormConfiguration;
use Lsv\SimpleMDEBundle\Render\SimpleMDERender;
use Lsv\SimpleMDEBundle\Twig\LsvSimpleMDETwigExtension;
use PHPUnit\Framework\TestCase;

class LsvSimpleMDEExtensionTest extends TestCase
{
    private LsvSimpleMDETwigExtension $extension;

    protected function setUp(): void
    {
        $config = new FormConfiguration([]);
        $render = new SimpleMDERender($config);
        $this->extension = new LsvSimpleMDETwigExtension($render);
    }

    /**
     * @test
     */
    public function will_render_widget(): void
    {
        self::assertIsString($this->extension->renderWidget('id', []));
    }

    /**
     * @test
     */
    public function has_functions(): void
    {
        self::assertCount(1, $this->extension->getFunctions());
    }
}
