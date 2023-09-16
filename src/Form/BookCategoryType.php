<?php

namespace App\Form;

use App\Entity\BookCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bkCatName')
            ->add('bookCategory', EntityType::class, [
                'class' => BookCategory::class,
                'choice_label' => 'bk_cat_name',
                'expanded' => false,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookCategory::class,
        ]);
    }
}
