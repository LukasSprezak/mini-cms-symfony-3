<?php

namespace AppBundle\Form\User;

use AppBundle\Entity\User;
use Symfony\Component\{
    Form\AbstractType,
    Form\FormBuilderInterface,
    OptionsResolver\OptionsResolver
};
use Symfony\Component\Form\Extension\Core\Type\{
    EmailType,
    PasswordType,
    RepeatedType,
    SubmitType,
    TextType
};

final class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nazwa użytkownika'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Hasło'],
                'second_options' => ['label' => 'Powtórz hasło' ]
                ])
            ->add('fullName', TextType::class, [
                'label' => 'Imię i Nazwisko'
            ])
            ->add('Register', SubmitType::class, [
                'label' => 'Dodaj użytkownika'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => User::class
        ]);
    }
}
