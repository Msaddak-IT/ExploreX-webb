<?php

namespace App\Form;


use App\Entity\Offres;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class OffreajoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('destination')
            
            ->add('debut', DateType::class, [
            
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            
                ->add('fin', DateType::class, [
                    'widget' => 'single_text', // Afficher en tant qu'entrée texte unique
                    'format' => 'yyyy-MM-dd', // Définir le format de date souhaité
                    ])
            ->add('prix')
            ->add('service', ChoiceType::class, [
               
                'choices' => [
                    'Kids' => 'Kids',
                    'couple' => 'couple',
                    'groupe' => 'groupe',
                ],
                'choice_label' => function ($choice, $key, $value) {
                    return 'Libellé : ' . $key;
                },
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offres::class,
        ]);
    }
}
