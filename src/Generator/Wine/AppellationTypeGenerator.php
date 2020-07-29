<?php

namespace App\Generator\Wine;

use App\Entity\Wine\Appellation;
use App\Form\Wine\AppellationType;
use App\Generator\AbstractGenerator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;

class AppellationTypeGenerator extends AbstractGenerator
{
    /** @var FormFactoryInterface */
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /** @return FormView */
    public function generate()
    {
        $form = $this->formFactory->create(AppellationType::class, new Appellation());

        return $form->createView();
    }
}