<?php
namespace App\Form;

use App\Entity\Affectation;
use App\Entity\Vehicule;
use App\Entity\VisiteurMedical;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class AffectationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choice_label' => 'id', 
                'placeholder' => 'Sélectionner un véhicule',
                'attr' => ['class' => 'form-control'],  
            ])
            ->add('visiteur', EntityType::class, [
                'class' => VisiteurMedical::class,
                'choice_label' => 'nom', 
                'placeholder' => 'Sélectionner un visiteur médical',
                'attr' => ['class' => 'form-control'],  
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'attr' => ['class' => 'form-control'], 
                'required' => true,
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'attr' => ['class' => 'form-control'],  
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
