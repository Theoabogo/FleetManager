<?php

namespace App\Form;

use App\Entity\Driver;
use App\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand')
            ->add('model')
            ->add('plateNumber')
            ->add('color')
            ->add('fuel')
            ->add('mileage')
            ->add('status')
            ->add('inServiceDate')
            ->add('driver', EntityType::class, [
                'class' => Driver::class,
                'choice_label' => 'lastName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}
