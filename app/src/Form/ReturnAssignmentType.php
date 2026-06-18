<?php

namespace App\Form;

use App\Entity\Assignment;
use App\Entity\Driver;
use App\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReturnAssignmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('returnedAt', DateTimeType::class, [
                'label' => 'Date de retour',
                'widget' => 'single_text',
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
            ]);  
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Assignment::class,
        ]);
    }
}
