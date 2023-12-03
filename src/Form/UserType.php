<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'User' => 'user',
                    'Admin' => 'admin',
                    'constraints' => [
                        new Assert\NotBlank(),

                    ],
                ],
                'multiple' => false, // Set to false if you want a single choice
                'expanded' => false, // Set to false if you want a dropdown select
            ])
            ->add('cin', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 8, 'max' => 8]),
                ],
            ])
            ->add('nom')
            ->add('prenom')
            ->add('email', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                ],
            ])
            ->add('pseudo')
            ->add('mdp', PasswordType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Password should not be blank.',
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Password should be at least 6 characters long.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/',
                        'message' => 'Password must contain at least one digit, one lowercase letter, one uppercase letter, and be at least 6 characters long.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
