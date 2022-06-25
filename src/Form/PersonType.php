<?php

namespace App\Form;

use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('date_de_naissance', BirthdayType::class,[
            'attr' => ['class' => 'inlineForm'],
        ])
        ->add('nom_de_code', NomDeCodeAjouter::class, [
            'attr' => ['class' => 'inlineForm'],
            'label' => false
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
            'inherit_data' => true,
        ]);
    }
}