<?php

namespace App\Form;

use App\Entity\Remboursement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;


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
            'constraints' => [
                new Callback([$this, 'validateDates']),
            ],
        ]);
    }
    

    public function validateDates($data, ExecutionContextInterface $context)
{
    $date_rembour = $data-> getDateRembour();



    $today = new \DateTime('today');

    $date_rembourConstraint = new GreaterThanOrEqual([
        'value' => $today,
        'message' => 'Date remboursement ne peut pas être antérieure au date dajout de reclamation ',
    ]);


    $this->validateDateWithConstraint($date_rembour, $date_rembourConstraint, 'date_rembour', $context);

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





