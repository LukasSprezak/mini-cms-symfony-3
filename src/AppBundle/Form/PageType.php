<?php

namespace AppBundle\Form;

use AppBundle\Entity\Page;
use Symfony\Component\{
    Form\AbstractType,
    Form\FormBuilderInterface,
    OptionsResolver\OptionsResolver
};
use Symfony\Component\Form\Extension\Core\Type\{
    ChoiceType,
    DateTimeType,
    TextareaType,
    TextType
};

final class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('alias', TextType::class, [
                'label' => 'page.web_address'
            ])
            ->add('title', TextType::class, [
                'label' => 'page.title'
            ])
            ->add('description', TextType::class, [
                'label' => 'page.description'
            ])
            ->add('keywords', TextType::class, [
                'label' => 'page.keywords'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'page.content',
                'data_class' => null,
                'attr' => [
                    'required' => false,
                    'entity_encoding'=> 'raw',
                    'class' => 'tinymce',
                    'data-theme' => 'advanced',
                    'choice_label' => 'content',
                    'by_reference' => false,
                    'cols' => 20,
                    'rows' => 10,
                    'allow_add' => true,
                ]])
            ->add('enabled', ChoiceType::class, [
                'choices'  => [
                    'menu.yes' => true,
                    'menu.no' => false,
                ],
            ])
            ->add('hiddenSidebar', ChoiceType::class, [
                'label' => 'page.hidden_sidebar',
                'required' => false,
                'choices' => [
                    'menu.yes' => true,
                    'menu.no' => false,
                ]
            ])
            ->add(
                'createdAt',
                DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'js-datepicker'
                    ],
                'html5' => 'false',
                'data' => new \DateTime('+0 day + 0 minutes'),
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Page::class
        ]);
    }
}