<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ type est obligatoire.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[A-Za-z\s]*$/',
                        'message' => 'Le champ type ne doit contenir que des caractères alphabétiques .',
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ nom est obligatoire.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[A-Za-z\s]*$/',
                        'message' => 'Le champ nom ne doit contenir que des caractères alphabétiques .',
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Le champ description est obligatoire.',
                    ]),
                    new Assert\Regex([
                        'pattern' => '/^[A-Za-z\s]*$/',
                        'message' => 'Le champ description ne doit contenir que des caractères alphabétiques .',
                    ]),
                ],
            ])
        

        

            ->add('datet_reclama')
           

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
            'constraints' => [
                new Callback([$this, 'validateDates']),
            ],
        ]);
    }
    public function validateDates($data, ExecutionContextInterface $context)
    {
        $dateReclama = $data-> getDatetReclama();

    
    
        $today = new \DateTime('today');
    
        $dateReclamaConstraint = new GreaterThanOrEqual([
            'value' => $today,
            'message' => 'Date réclamation ne peut pas être antérieure',
        ]);
    
    
        $this->validateDateWithConstraint($dateReclama, $dateReclamaConstraint, 'datet_reclama', $context);

    }
    
    private function validateDateWithConstraint($date, $constraint, $fieldPath, $context)
    {
        $violations = $context->getValidator()->validate($date, $constraint);
    
        if (count($violations) > 0) {
            $context
                ->buildViolation($violations[0]->getMessage())
                ->atPath($fieldPath)
                ->addViolation();
        }
    }
}
