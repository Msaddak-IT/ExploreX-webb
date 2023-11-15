<?php

namespace App\Form;

use App\Entity\Bonplan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BonplanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameBonPlan')
            ->add('rating')
            ->add('startDate')
            ->add('endDate')
            ->add('avgPrice')
            ->add('location')
            ->add('typeBonPlan')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bonplan::class,
        ]);
    }
}
