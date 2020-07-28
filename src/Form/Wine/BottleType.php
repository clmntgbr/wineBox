<?php

namespace App\Form\Wine;

use App\Entity\Wine\Bottle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BottleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment')
            ->add('purchasePrice')
            ->add('status')
            ->add('purchaseAt')
            ->add('name')
            ->add('description')
            ->add('wine')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bottle::class,
        ]);
    }
}
