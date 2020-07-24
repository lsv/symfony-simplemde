<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundle\Configuration;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormConfiguration
{
    private static array $defaultConfig = [
        'enable' => [
            'default' => true,
            'setoptions' => false,
            'allowedtypes' => ['bool'],
        ],
        'auto_download_font_awesome' => [
            'default' => null,
            'setoptions' => true,
            'allowedtypes' => ['null', 'bool'],
            'elementkey' => 'autoDownloadFontAwesome',
        ],
        'autosave_delay' => [
            'default' => null,
            'setoptions' => true,
            'allowedtypes' => ['null', 'int'],
            'elementkey' => 'autosave.delay',
        ],
        'blockstyles_bold' => [
            'default' => null,
            'setoptions' => true,
            'allowedtypes' => ['null', 'string'],
            'elementkey' => 'blockStyles.bold',
        ],
    ];

    private array $config;

    public function __construct(array $config)
    {
        $defaultConfig = [];
        foreach (self::$defaultConfig as $key => $item) {
            $defaultConfig[$key] = $item['default'];
        }

        $this->config = array_merge($defaultConfig, $config);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        foreach (self::$defaultConfig as $key => $item) {
            $resolver->setDefault($key, $this->config[$key]);
            $resolver->setAllowedTypes($key, $item['allowedtypes']);
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $setAttr = static function (string $key) use ($options, $builder): void {
            if (null !== $options[$key]) {
                $builder->setAttribute($key, $options[$key]);
            }
        };

        if (!$options['enable']) {
            $setAttr('enable');

            return;
        }

        foreach (array_keys(self::$defaultConfig) as $key) {
            $setAttr($key);
        }
    }

    public function buildView(FormView $view, FormInterface $form): void
    {
        $config = $form->getConfig();
        $setView = static function (string $key) use ($config, $view): void {
            $view->vars[$key] = $config->getAttribute($key);
        };

        if (!$config->getAttribute('enable')) {
            $setView('enable');

            return;
        }

        foreach (array_keys(self::$defaultConfig) as $key) {
            $setView($key);
        }
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

        foreach (self::$defaultConfig as $key => $item) {
            if (!$item['setoptions']) {
                continue;
            }

            $setOptions($key, $item['elementkey'] ?? null);
        }

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
            /** @var array */
            $arr = &$arr[$key];
        }
        $arr = $value;
    }
}
