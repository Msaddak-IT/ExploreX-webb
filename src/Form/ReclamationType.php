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

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('nom')
            ->add('description')
            ->add('datet_reclama')
            ->add('submit',SubmitType::class)

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
