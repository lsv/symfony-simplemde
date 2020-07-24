<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundle\Twig;

use Lsv\SimpleMDEBundle\Render\SimpleMDERender;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LsvSimpleMDETwigExtension extends AbstractExtension
{
    private SimpleMDERender $render;

    public function __construct(SimpleMDERender $render)
    {
        $this->render = $render;
    }

    /**
     * @return TwigFunction[]
     *
     * @psalm-return array{0: TwigFunction}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('simplemde_widget', [$this, 'renderWidget'], ['is_safe' => ['html']]),
        ];
    }

    public function renderWidget(string $id, array $config): string
    {
        return $this->render->renderWidget($id, $config);
    }
}
