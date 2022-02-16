<?php

namespace App\Form;

use App\Entity\Planques;
use App\Entity\Pays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanquesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse')
            ->add('code', NomDeCodeAjouter::class)
            ->add('pays', EntityType::class, array(
                'class' => Pays::class,
                'choice_label' => 'nom',
                'choice_value' => 'id',
                'label' => 'Pays d\'origine'
            ))
            ->add('type', TypeDePlanquesType::class, array('label' =>'Type de Planque'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planques::class,
        ]);
    }
}
