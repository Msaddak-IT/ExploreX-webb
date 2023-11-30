<?php

namespace App\Form;

use App\Entity\Agence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Assurance;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nomAgence', TextType::class, [
            'label' => 'NomAgence',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('adresse', TextType::class, [
            'label' => 'Adresse',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('telephone', TextType::class, [
            'label' => 'Telephone',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('email', TextType::class, [
            'label' => 'Email',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('assurance', TextType::class, [
            'label' => 'Assurance',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('assurances', TextType::class, [
            'label' => 'Assurances',
            'attr' => ['class' => 'form-control'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agence::class,
        ]);
    }
}
