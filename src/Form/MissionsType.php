<?php

namespace App\Form;

use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('date_debut', DateType::class, [
                'data' =>  new \DateTime("now"),
            ])
            ->add('date_fin', DateType::class, [
                'data' =>  new \DateTime("now"),
            ])
            ->add('nom_de_code', NomDeCodeAjouter::class)
           
            ->add('agents')
            ->add('contacts')
            ->add('Cibles')
            ->add('type')
            ->add('statut')
            #->add('planques')
            ->add('specialite') 
            
            ->add('pays_planques', PaysEtPlanquesPourMissionType::class,[
               'mapped' =>  false,
               'allow_extra_fields' => 'true'
            ])
           #->add('pays')
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
