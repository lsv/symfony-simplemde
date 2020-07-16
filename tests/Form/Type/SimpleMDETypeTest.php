<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundleTest\Form\Type;

use Lsv\SimpleMDEBundle\Configuration\FormConfiguration;
use Lsv\SimpleMDEBundle\Form\Type\SimpleMDEType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class SimpleMDETypeTest extends TestCase
{
    private string $type;
    private FormFactoryInterface $factory;

    protected function setUp(): void
    {
        $this->type = SimpleMDEType::class;
        $editor = new SimpleMDEType(new FormConfiguration(['enable' => true]));
        $this->factory = Forms::createFormFactoryBuilder()
            ->addType($editor)
            ->getFormFactory();
    }

    /**
     * @test
     */
    public function invalid_configuration(): void
    {
        $this->expectException(UndefinedOptionsException::class);
        $this->expectExceptionMessageMatches('/The option "invalid_configuration" does not exist/');
        $this->factory->create($this->type, null, [
            'invalid_configuration' => null,
        ]);
    }

    /**
     * @test
     */
    public function is_enabled(): void
    {
        $form = $this->factory->create($this->type);
        $view = $form->createView();

        self::assertArrayHasKey('enable', $view->vars);
        self::assertTrue($view->vars['enable']);
    }

    /**
     * @test
     */
    public function is_disabled(): void
    {
        $form = $this->factory->create($this->type, null, [
            'enable' => false,
        ]);
        $view = $form->createView();

        self::assertArrayHasKey('enable', $view->vars);
        self::assertFalse($view->vars['enable']);
    }

    /**
     * @test
     */
    public function auto_download_fontAwesome(): void
    {
        $form = $this->factory->create($this->type, null, [
            'enable' => true,
            'auto_download_font_awesome' => true,
        ]);
        $view = $form->createView();

        self::assertArrayHasKey('auto_download_font_awesome', $view->vars);
        self::assertTrue($view->vars['auto_download_font_awesome']);
    }

    /**
     * @test
     */
    public function autosave_delay(): void
    {
        $form = $this->factory->create($this->type, null, [
            'enable' => true,
            'autosave_delay' => 5000,
        ]);
        $view = $form->createView();

        self::assertArrayHasKey('autosave_delay', $view->vars);
        self::assertSame(5000, $view->vars['autosave_delay']);
    }

    /**
     * @test
     */
    public function blockstyles_bold(): void
    {
        $form = $this->factory->create($this->type, null, [
            'enable' => true,
            'blockstyles_bold' => 'foo',
        ]);
        $view = $form->createView();

        self::assertArrayHasKey('blockstyles_bold', $view->vars);
        self::assertSame('foo', $view->vars['blockstyles_bold']);
    }
}
