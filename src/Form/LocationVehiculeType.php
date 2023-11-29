<?php

namespace App\Form;

use App\Entity\LocationVehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class LocationVehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('cin_client_vehicule', IntegerType::class, [
            'label' => 'Enter your CIN ',
            'constraints' => [
                new NotBlank(['message' => 'CIN Client cannot be empty.']),
                new Regex([
                    'pattern' => '/^\d{8}$/',
                    'message' => 'CIN must be exactly 8 digits.',
                ]),
            ],
        ])
        ->add('duree_loc_vehicule', TextType::class, [
            'label' => 'Rental duration',
            'constraints' => [
                new NotBlank(['message' => 'Rental duration cannot be empty.']),
                new Regex([
                    'pattern' => '/^\d+\s*days$/i',
                    'message' => 'Duration must be an integer followed by the word "days".',
                ]),
                new Length([
                    'max' => 255, // adjust the max length as needed
                    'maxMessage' => 'Duration is too long.',
                ]),
            ],
        ])
        ->add('pickup_vehicule', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'label' => 'Pick-up date',
        ])
        ->add('return_vehicule', DateType::class, [
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'label' => 'Return date',
        ])
        ->add('montantLocation', null, [
            'label' => 'Full price ( 120 dt per day )',
            'constraints' => [
                new NotBlank(['message' => 'Full price cannot be empty.']),
            ],
        ])
        ->add('vehicules', EntityType::class, [
            'class' => 'App\Entity\Vehicule',
            'choice_label' => 'matricule',
            'placeholder' => 'choose vehicule',
            'required' => true,
            'label' => 'Associated vehicle',
        ])
        ->add('submit', SubmitType::class)
        ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();

                // Retrieve the rental duration submitted
                $dureeLoc = $data['duree_loc_vehicule'];

                // Extract the integer from the duration (example: "5 days" -> 5)
                $dureeInt = (int) preg_replace('/[^0-9]/', '', $dureeLoc);

                // Calculate the rental amount
                $montant = $dureeInt * 120;

                // Modify the submitted data to include the calculated amount
                $data['montantLocation'] = $montant;

                $event->setData($data);
            });
    
        }
        
        
        
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LocationVehicule::class,
            'constraints' => [
                new Callback([$this, 'validateDates']),
            ],
        ]);
    }
    public function validateDates($data, ExecutionContextInterface $context)
    {
        $pickupDate = $data->getPickupVehicule();
        $returnDate = $data->getReturnVehicule();
        $rentalDuration = $data->getDureeLocVehicule();
    
        // Custom validation logic
        if ($pickupDate > $returnDate) {
            $context
                ->buildViolation('Pick-up date must be before the return date.')
                ->atPath('pickup_vehicule')
                ->addViolation();
        }
        // Convertir la durée en un nombre entier
$duration = (int)$rentalDuration;

// Vérifier si la durée est valide
if ($duration <= 0) {
    // La durée doit être un nombre entier positif
    // Vous pouvez gérer cette erreur de la manière qui convient à votre application
    $context
        ->buildViolation('The rental period must be a positive integer.')
        ->atPath('duree_loc_vehicule')
        ->addViolation();
} else {
    // Calculate the expected return date based on pickup date and rental duration
    $expectedReturnDateTime = clone $pickupDate;
    $expectedReturnDateTime->modify('+' . $duration . ' days');

    if ($returnDate != $expectedReturnDateTime) {
        $context
            ->buildViolation('The period between dates must equal the rental duration..')
            ->atPath('return_vehicule')
            ->addViolation();
    }
}
    
        $today = new \DateTime('today');
    
        $pickupDateConstraint = new GreaterThanOrEqual([
            'value' => $today,
            'message' => 'Pick-up date cannot be in the past.',
        ]);
    
        $returnDateConstraint = new GreaterThanOrEqual([
            'value' => $today,
            'message' => 'Return date cannot be in the past.',
        ]);
    
        $this->validateDateWithConstraint($pickupDate, $pickupDateConstraint, 'pickup_vehicule', $context);
        $this->validateDateWithConstraint($returnDate, $returnDateConstraint, 'return_vehicule', $context);
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
