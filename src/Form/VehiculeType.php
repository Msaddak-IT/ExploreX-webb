<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('matricule', IntegerType::class, ['constraints' => [
                new NotBlank(['message' => 'Matricule cannot be empty.']),
                new Regex([
                    'pattern' => '/^\d{6}$/',
                    'message' => 'Matricule must be exactly 6 digits.',
                ]),
            ],
            ])
        ->add('type_vehicule', ChoiceType::class, [
            'choices' => [
                'Voiture' => 'Voiture',
                'Van' => 'Van',
            ],
            'label' => 'Vehicle Type',
        ])
        ->add('marque_vehicule', ChoiceType::class, [
            'choices' => [
                'KIA' => 'KIA',
                'Peugeot' => 'Peugeot',
                'Volkswagen' => 'Volkswagen',
            ],
            'label' => 'Brand',
        ])
        ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
