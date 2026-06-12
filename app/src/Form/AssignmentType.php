<?php

namespace App\Form;

use App\Entity\Assignment;
use App\Entity\Driver;
use App\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
USE Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AssignmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          ->add('vehicle', EntityType::class,[
                'label' => 'Véhicule',
                'class' => Vehicle::class,
                'choice_label' => function(Vehicle $vehicle) {
                    return $vehicle->getModel() . ' - ' . $vehicle->getColor() . ' - ' . $vehicle->getPlateNumber() .  ' - ' . '[' . $vehicle->getStatus() . ']';
                },
                'placeholder' => 'Choisir un véhicule'
            ])
             ->add('driver', EntityType::class, [
                'label' => 'Conducteur',
                'class' => Driver::class,
               'choice_label' => function (Driver $driver) {
        return $driver->getLastName() . ' ' . $driver->getFirstName();
    },
                'placeholder' => 'Choisir un conducteur'
            ])

            ->add('assignedAt', null, ['label' =>'Date d\'affectation'])
           
            ->add('comment', textareaType::class, [
                'label' =>'Commentaire',
                'required' => false,
                ])
          
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assignment::class,
        ]);
    }
}
