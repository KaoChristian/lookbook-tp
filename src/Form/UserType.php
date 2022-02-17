<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email :'
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password :'
            ])
            ->add('userName', TextType::class, [
                'label' => 'Pseudo :'
            ])
            ->add('addresses', EntityType::class, [
                'class' => Address::class,
                'label' => 'Adresse :',
                'required' => false
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
                'required' => false
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom :',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'method' => 'POST'
        ]);
    }
}
