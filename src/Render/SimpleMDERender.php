<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundle\Render;

use Lsv\SimpleMDEBundle\Configuration\FormConfiguration;

class SimpleMDERender
{
    private FormConfiguration $configuration;

    public function __construct(FormConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function renderWidget(string $id, array $config): string
    {
        $elementConfiguration = $this->configuration->render($config);

        $json = [];
        foreach ($elementConfiguration as $key => $value) {
            $json[] = "{$key}: {$this->valueToJson($value)}";
        }

        return sprintf(
            "let simplemde_%s = new SimpleMDE({element: document.getElementById('%s')%s})",
            $id,
            $id,
            $json ? ', '.implode(',', $json) : ''
        );
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    private function valueToJson($value)
    {
        if (is_string($value)) {
            return "\"{$value}\"";
        }

        if (is_bool($value)) {
            if (true === $value) {
                return 'true';
            }

            return 'false';
        }

        if (is_array($value)) {
            $return = [];
            foreach ($value as $key => $item) {
                $return[] = sprintf('{ %s: %s }', $key, $this->valueToJson($item));
            }

            return implode(', ', $return);
        }

        return $value;
    }
}
