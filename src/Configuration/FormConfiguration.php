<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundle\Configuration;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormConfiguration
{
    public static array $defaultConfig = [
        'enable' => true,
        'auto_download_font_awesome' => null,
        'autosave_delay' => null,
        'blockstyles_bold' => null,
    ];

    private array $config;

    public function __construct(array $config)
    {
        $this->config = array_merge(self::$defaultConfig, $config);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('enable', $this->config['enable']);
        $resolver->setAllowedTypes('enable', ['bool']);

        $resolver->setDefault('autosave_delay', $this->config['autosave_delay']);
        $resolver->setAllowedTypes('autosave_delay', ['null', 'int']);

        $resolver->setDefault('auto_download_font_awesome', $this->config['auto_download_font_awesome']);
        $resolver->setAllowedTypes('auto_download_font_awesome', ['null', 'bool']);

        $resolver->setDefault('blockstyles_bold', $this->config['blockstyles_bold']);
        $resolver->setAllowedTypes('blockstyles_bold', ['null', 'string']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $setAttr = static function (string $key) use ($options, $builder): void {
            if (null !== $options[$key]) {
                $builder->setAttribute($key, $options[$key]);
            }
        };

        $setAttr('enable');
        if (!$options['enable']) {
            return;
        }

        $setAttr('autosave_delay');
        $setAttr('auto_download_font_awesome');
        $setAttr('blockstyles_bold');
    }

    public function buildView(FormView $view, FormInterface $form): void
    {
        $config = $form->getConfig();
        $setView = static function (string $key) use ($config, $view): void {
            $view->vars[$key] = $config->getAttribute($key);
        };

        $setView('enable');
        if (!$view->vars['enable']) {
            return;
        }

        $setView('autosave_delay');
        $setView('auto_download_font_awesome');
        $setView('blockstyles_bold');
    }

    /**
     * @param array<array-key, mixed> $config
     */
    public function render(array $config): array
    {
        $options = [];
        $setOptions = function (string $optionKey, ?string $elementKey = null) use (&$options, $config): void {
            $this->setOptions($config, $options, $optionKey, $elementKey);
        };

        $setOptions('autosave_delay', 'autosave.delay');
        $setOptions('auto_download_font_awesome', 'autoDownloadFontAwesome');
        $setOptions('blockstyles_bold', 'blockStyles.bold');

        return $options;
    }

    private function setOptions(array $config, array &$options, string $optionKey, ?string $elementKey = null): void
    {
        if (!isset($config[$optionKey])) {
            return;
        }

        if ($elementKey && false !== strpos($elementKey, '.')) {
            $this->assignByPath($options, $elementKey, $config[$optionKey]);

            return;
        }

        $options[$elementKey ?? $optionKey] = $config[$optionKey];
    }

    /**
     * @param mixed $value
     */
    private function assignByPath(array &$arr, string $path, $value, string $separator = '.'): void
    {
        $keys = (array) explode($separator, $path);
        foreach ($keys as $key) {
            /**
             * @var array $arr
             */
            $arr = &$arr[$key];
        }
        $arr = $value;
    }
}
