<?php

namespace App\Form\Wine;

use App\Entity\Wine\Wine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('name')
            ->add('capacity')
            ->add('color')
            ->add('appellation')
            ->add('region')
            ->add('domain')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wine::class,
        ]);
    }
}
