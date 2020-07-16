<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundle\Form\Type;

use Lsv\SimpleMDEBundle\Configuration\FormConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SimpleMDEType extends AbstractType
{
    private FormConfiguration $configuration;

    public function __construct(FormConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->configuration->buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $this->configuration->buildView($view, $form);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $this->configuration->configureOptions($resolver);
    }

    public function getBlockPrefix(): string
    {
        return 'simplemde';
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }
}
