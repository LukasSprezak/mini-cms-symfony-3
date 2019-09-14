<?php

namespace AppBundle\Form\Post;

use AppBundle\Entity\Post\AbstractPost;
use Symfony\Component\{
    Form\AbstractType,
    Form\FormBuilderInterface,
    OptionsResolver\OptionsResolver,
    Form\Extension\Core\Type\TextType
};

final class AbstractPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'tag.title',
                'attr' => [
                    'placeholder' => 'tag.title'
                ]
            ])
            ->add('slug', TextType::class, [
                'label' => 'tag.web_address',
                'attr' => [
                    'placeholder' => 'tag.web_address'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => AbstractPost::class
        ]);
    }
}