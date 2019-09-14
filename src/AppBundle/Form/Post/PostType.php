<?php

namespace AppBundle\Form\Post;

use AppBundle\Entity\Post\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\{
    ChoiceType,
    DateTimeType,
    TextareaType,
    TextType
};
use Symfony\Component\{Form\AbstractType,
    Form\FormBuilderInterface,
    OptionsResolver\OptionsResolver
};

final class PostType extends AbstractType
{
    public function getName()
    {
        return 'post';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'post.title',
                'attr' => [
                    'placeholder' => 'post.title'
                ]
            ])
            ->add('slug', TextType::class, [
                'label' => 'post.web_address',
                'attr' => [
                    'placeholder' => 'post.web_address'
                ]
            ])
            ->add("content", TextareaType::class, [
                "label" => "post.content",
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
            ->add('description', TextType::class, [
                'label' => 'post.description'
            ])
            ->add('keywords', TextType::class, [
                'label' => 'post.keywords'
            ])

            ->add("publishedDate",
                DateTimeType::class, [
                'label' => 'post.add_published',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'js-datepicker'
                ],
                'html5' => 'false',
                'data' => new \DateTime('+0 day + 0 minutes'),
            ])
            ->add('category', EntityType::class, [
                'class' => 'AppBundle\Entity\Post\Category',
                'label' => 'post.category'
            ])
            ->add('tags', EntityType::class, [
                'class' => 'AppBundle\Entity\Post\Tag',
                'label' => 'post.tags',
                'multiple' => true,
                'attr' => [
                    'placeholder' => 'post.add_tags'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'post.choice_status',
                'choices' => [
                    Post::STATUS_PUBLISHED => Post::STATUS_PUBLISHED,
                    Post::STATUS_UNPUBLISHED => Post::STATUS_UNPUBLISHED,
                    Post::STATUS_DRAFT => Post::STATUS_DRAFT,
                ]
            ])
            ->add('author', EntityType::class, [
                'class' => 'AppBundle\Entity\User',
                'label' => 'post.author'
            ])
            ->add("imageFile", VichImageType::class, [
                'required' => false,
                'download_uri' => false,
            ])
            ->add('alt', TextType::class, [
                'label' => 'post.alt',
                'attr' => [
                    'placeholder' => 'post.alt'
                ]
            ])
            ->add('beginningText', TextType::class, [
                'label' => 'post.beginning_text',
                'attr' => [
                    'placeholder' => 'post.beginning_text'
                ]
            ])
            ->add('hiddenSidebar', ChoiceType::class, [
                'label' => 'post.hidden_sidebar',
                'required' => false,
                'choices' => [
                    'menu.yes' => true,
                    'menu.no' => false,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => Post::class
        ]);
    }
}