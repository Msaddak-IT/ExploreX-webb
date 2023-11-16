<?php

namespace App\Form;

use App\Entity\Remboursement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class RemboursementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant_rembour', MoneyType::class, [
                'currency' => 'TND', // Changez la devise 
                'constraints' => [
                    new PositiveOrZero([
                        'message' => 'Le montant doit être un nombre positif ou zéro.',
                    ]),
                ],
            ])
            ->add('date_rembour')
            ->add('id_rec')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remboursement::class,
        ]);
    }
}
