<?php

namespace AppBundle\Form\Gallery;

use AppBundle\Entity\Gallery\Gallery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\{
    AbstractType,
    Extension\Core\Type\CollectionType,
    Extension\Core\Type\TextType,
    FormBuilderInterface
};

final class GalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class, [
                'label' => 'gallery.name'
            ])
            ->add("imageFile", VichImageType::class, [
                'required' => false,
                'download_uri' => false,
                'label' => 'gallery.alt',
            ])
            ->add('owner', EntityType::class, [
                'class' => 'AppBundle:User',
                'choice_label' => 'username',
                'label' => 'gallery.choice_user',
            ])
            ->add('item', CollectionType::class, [
                'entry_type' => ItemType::class,
                'entry_options' => [
                    'label' => false
                ],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => Gallery::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_gallery';
    }


}
