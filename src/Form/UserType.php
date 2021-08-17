<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
            ->add('email')
            ->add('firstName')
            ->add('lastName')
            ->add('birthdate')
            ->add('picture')
            ->add('langue')
            ->add('role')
            ->add('phoneNumber')
            ->add('password')
            ->add('isLogin')
            ->add('isVerified')
            ->add('isActive')
            ->add('description')
            ->add('qualification')
            ->add('city')
            ->add('street')
            ->add('adressDescription')
            ->add('postalCode')
            ->add('landLinePhoneNumber')
            ->add('lastLoginDate')
            ->add('createdDate')
            ->add('updateDate')
            ->add('deletedDate')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
