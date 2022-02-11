<?php

namespace App\Form;

use App\Entity\Missions;
use App\Entity\Planques;
use App\Entity\Pays;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysEtPlanquesPourMissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pays', EntityType::class, array(
            'class' => Pays::class,
            'choice_label' => 'nom',
            'choice_value' => 'id',
           # 'placeholder' => 'Pays d\'origine',
            'label' => 'Pays d\'origine'
        ))
        ->add('planque', EntityType::class, array(
            'class' => Planques::class,
            'label' => 'planque',
           # 'choice_label' => 'code',
           # 'choice_value' => 'id',
           # 'placeholder' => 'Pays d\'origine',
           # 'label' => 'Pays d\'origine'
        ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
