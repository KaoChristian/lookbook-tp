<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre du livre :"
            ])
            ->add('price', MoneyType::class, [
                "label" => "Prix :"
            ])
            ->add('images', UrlType::class, [
                "label" => "URL de l'image"
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description :"
            ])
            ->add('publishDate', DateType::class, [
                "label" => "Date de publication :"
            ])
            ->add('isbn', TextType::class, [
                "label" => "Numéro ISBN"
            ])
            ->add('pageAmount', NumberType::class, [
                "label" => "Nombres de page :"
            ])
            ->add('language', LanguageType::class, [
                "label" => "Langue :"
            ])
            ->add('bookSize', TextType::class, [
                "label" => "Format du livre :"
            ])
            ->add('authors', EntityType::class, [
                "class" => Author::class,
                "choice_label" => "name",
                "required" => false,
                "multiple" => true,
                "expanded" => true, 
            ])
            ->add('publisher', EntityType::class, [
                "class" => Publisher::class,
                "choice_label" => "title",
                "required" => false,
                "multiple" => true,
                "expanded" => true,
            ])
            ->add('categories', EntityType::class, [
                "class" => Category::class,
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
            'data_class' => Book::class,
            'method' => 'POST'
        ]);
    }
}
