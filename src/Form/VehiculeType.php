<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez la marque']
            ])
            ->add('modele', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez le modèle']
            ])
            ->add('immatriculation', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez l\'immatriculation']
            ])
            ->add('kilometrage', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Entrez le kilométrage']
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Disponible' => 'Disponible',
                    'En révision' => 'En révision',
                    'Indisponible' => 'Indisponible',
                    'Loué' => 'Loué'
                ],
                'attr' => ['class' => 'form-select'],
                'placeholder' => 'Sélectionner le statut',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
