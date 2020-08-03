<?php

namespace App\Form\Wine;

use App\Entity\Wine\Bottle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BottleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        dump($options['file_required']);
        die;
        $builder
            ->add('comment')
            ->add('alertAt')
            ->add('alertComment')
            ->add('apogeeAt')
            ->add('purchasePrice')
            ->add('purchaseAt')
            ->add('wine')
            ->add('location')
            ->add('file', FileType::class, [
                'required' => $options['file_required']
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bottle::class,
            'file_required' => false,
        ]);
    }
}
