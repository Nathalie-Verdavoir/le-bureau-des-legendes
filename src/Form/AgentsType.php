<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\NomDeCode;
use App\Entity\Pays;
use App\Entity\Specialites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('date_de_naissance')
            ->add('specialites', EntityType::class, array(
                'mapped' => false,
                'class' => Specialites::class,
                'choice_label' => 'nom',
                'placeholder' => 'spécialités',
                'label' => 'spécialités'
            ))
            ->add('nom_de_code', EntityType::class, array(
                'mapped' => false,
                'class' => NomDeCode::class,
                'choice_label' => 'code',
                'placeholder' => 'Nom De Code',
                'label' => 'Nom De Code'
            ))
            ->add('nationalite', EntityType::class, array(
                'mapped' => false,
                'class' => Pays::class,
                'choice_label' => 'nom',
               # 'placeholder' => 'Pays d\'origine',
                'label' => 'Pays d\'origine'
            ))
            ->add('missions')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agents::class,
        ]);
    }
}
