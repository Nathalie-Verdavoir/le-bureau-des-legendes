<?php

namespace App\Form;

use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date_debut')
            ->add('date_fin')
            ->add('nom_de_code')
            ->add('pays')
            ->add('agents')
            ->add('contacts')
            ->add('Cibles')
            ->add('type')
            ->add('statut')
            ->add('planques')
            ->add('specialite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
