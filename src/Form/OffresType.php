<?php

namespace App\Form;
use App\Form\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Service;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Expression;


class OffresType extends AbstractType
{ 
   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
       
       
        ->add('destination', null, [
            'constraints' => [
                new NotBlank(['message' => 'Le champ "Destination" ne peut pas être vide.']),
            ],
        ])
        /*
        ->add('debut', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => false, // Allow null values
        ])*/
        /*
        ->add('fin', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'required' => false, // Allow null values
            'constraints' => [
                new Callback([$this, 'validateDateRange']),
            ],
        ])
        */
        ->add('debut', DateType::class, [
            'label' => 'Date de début',
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'constraints' => [
                new NotBlank(['message' => 'Le champ "Date de début" ne peut pas être vide.']),
            ],
        ])
        ->add('fin', DateType::class, [
            'label' => 'Date de fin ',
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'constraints' => [
                new NotBlank(['message' => 'Le champ "Date de fin" ne peut pas être vide.']),
                new Callback([$this, 'validateDateRange']),
            ],
        ])
            ->add('prix', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ "Prix" ne peut pas être vide.']),
                    new Type(['type' => 'numeric', 'message' => 'Le prix doit être un nombre.']),
                    // You can add more constraints as needed.
                ],
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'nomService',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner un service.']),
                ],
            ]);
            /*
            ->add('submit', SubmitType::class) */;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
           /* 'data_class' => Offres::class,*/
           'data_class' => \App\Entity\Offres::class,
        ]);
    }
    public function validateDateRange($value, ExecutionContextInterface $context): void
    {
        $form = $context->getRoot();
    
        $debut = $form['debut']->getData();
    
        if ($debut !== null && $value !== null && $debut > $value) {
            $context->buildViolation('La date de fin doit être postérieure ou égale à la date de début.')
                ->atPath('fin')
                ->addViolation();
        }
    }
}






