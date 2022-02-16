<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom de l'auteur :"
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description :"
            ])
            ->add('books', EntityType::class, [
                "class" => Book::class,
                "choice_label" => "title",
                "required" => false,
                "multiple" => true,
                "expanded" => true, 
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Valider"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
            'method' => 'POST'
        ]);
    }
}
