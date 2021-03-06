<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundleTest\Render;

use Lsv\SimpleMDEBundle\Configuration\FormConfiguration;
use Lsv\SimpleMDEBundle\Render\SimpleMDERender;
use PHPUnit\Framework\TestCase;

class SimpleMDERenderTest extends TestCase
{
    private SimpleMDERender $render;

    protected function setUp(): void
    {
        $configuration = new FormConfiguration([
            'enable' => true,
            'download_fontawesome' => true,
        ]);
        $this->render = new SimpleMDERender($configuration);
    }

    /**
     * @test
     */
    public function willRenderDefault(): void
    {
        $rendered = $this->render->renderWidget('id', []);
        self::assertSame("let simplemde_id = new SimpleMDE({element: document.getElementById('id')})", $rendered);
    }

    /**
     * @test
     */
    public function willRenderWithAutodownloadFontawesome(): void
    {
        $rendered = $this->render->renderWidget('id', ['auto_download_font_awesome' => true]);
        self::assertSame("let simplemde_id = new SimpleMDE({element: document.getElementById('id'), autoDownloadFontAwesome: true})", $rendered);
    }

    /**
     * @test
     */
    public function willRenderFalseValue(): void
    {
        $rendered = $this->render->renderWidget('id', ['auto_download_font_awesome' => false]);
        self::assertSame("let simplemde_id = new SimpleMDE({element: document.getElementById('id'), autoDownloadFontAwesome: false})", $rendered);
    }

    /**
     * @test
     */
    public function willRenderAutosaveDelay(): void
    {
        $rendered = $this->render->renderWidget('id', ['autosave_delay' => 1000]);
        self::assertSame("let simplemde_id = new SimpleMDE({element: document.getElementById('id'), autosave: { delay: 1000 }})", $rendered);
    }

    /**
     * @test
     */
    public function willRenderBlockstylesBold(): void
    {
        $rendered = $this->render->renderWidget('id', ['blockstyles_bold' => 'foo']);
        self::assertSame("let simplemde_id = new SimpleMDE({element: document.getElementById('id'), blockStyles: { bold: \"foo\" }})", $rendered);
    }
}
