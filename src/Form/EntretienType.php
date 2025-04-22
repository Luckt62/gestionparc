<?php
namespace App\Form;

use App\Entity\Entretien;
use App\Entity\Vehicule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntretienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', null, [
                'attr' => ['class' => 'form-control'], 
            ])
            ->add('date', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'], 
            ])
            ->add('cout', null, [
                'attr' => ['class' => 'form-control'], 
            ])
            ->add('piece_jointe', FileType::class, [
                'label' => 'Pièce jointe',
                'mapped' => false, 
                'required' => false, 
                'attr' => ['class' => 'form-control'],
            ])
            ->add('vehicule', EntityType::class, [
                'class' => Vehicule::class,
                'choice_label' => function (Vehicule $vehicule) {
                    return $vehicule->getImmatriculation() . ' - ' . $vehicule->getMarque() . ' ' . $vehicule->getModele();
                },
                'attr' => ['class' => 'form-control'], 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entretien::class,
        ]);
    }
}
