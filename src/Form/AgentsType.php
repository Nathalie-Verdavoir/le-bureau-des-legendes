<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\Pays;
use App\Entity\Specialites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('date_de_naissance', BirthdayType::class)
            ->add('specialites', EntityType::class, array(
                'class' => Specialites::class,
                'allow_extra_fields' => true,
                'label' => 'Spécialités',
                'expanded' =>true ,
                'multiple'=> true,
                'row_attr' => ['class' => 'MaClass'],
            ))
            ->add('nom_de_code', NomDeCodeAjouter::class,
            [
                'label' => false,
            ])

            ->add('nationalite', EntityType::class, array(
                'class' => Pays::class,
                'choice_label' => 'nom',              
                'label' => 'Pays d\'origine'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agents::class,
        ]);
    }
}
