<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\NotBlank;  // Add this line for constraint
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;

class Service1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
      
            ->add('nomService', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ "Nom du service" ne peut pas être vide.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le nom du service ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ],
            ])
            ->add('descriptionService', TextareaType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ "Description du service" ne peut pas être vide.']),
                ],
                ])
            
                ->add('prixService', NumberType::class, [
                    'constraints' => [
                        new NotBlank(['message' => 'Le champ "Prix du service" ne peut pas être vide.']),
                        new GreaterThan([
                            'value' => 0,
                            'message' => 'Le prix du service doit être supérieur à zéro.',
                        ]),
                    ],
                ])
                
            ;
       
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
