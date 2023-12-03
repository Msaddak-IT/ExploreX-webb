<?php

namespace App\Form;

use App\Entity\CodePromo;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints as Assert;

class CodePromoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code')
            ->add('valeur', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Range([
                        'min' => 0,
                        'max' => 90,
                        'minMessage' => 'Value should be at least {{ limit }}.',
                        'maxMessage' => 'Value should be at most {{ limit }}.',
                    ]),
                ],
            ])
            ->add('datexpiration',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CodePromo::class,
        ]);
    }
}
