<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\NewsletterEmail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une catégorie',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Inscription'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsletterEmail::class,
        ]);
    }
}
