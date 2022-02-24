<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\Cibles;
use App\Entity\Contacts;
use App\Entity\Missions;
use App\Entity\Pays;
use App\Entity\Planques;
use App\Entity\Specialites;
use App\Repository\PlanquesRepository;
use App\Validator\CiblesAgents;
use App\Validator\ContactsPays;
use App\Validator\MissionPlanques;
use App\Validator\UnAgentAvecLaSpecialiteDeMission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'attr' => ['class' => 'inlineForm'],
            ])
            ->add('date_fin', DateType::class, [
                'data' =>  new \DateTime("now"),
                'attr' => ['class' => 'inlineForm'],
            ])
            ->add('nom_de_code', NomDeCodeAjouter::class, [
                'attr' => ['class' => 'inlineForm'],
                'label' => false
            ])
            ->add('type')
            ->add('statut')
            ->add('specialite', EntityType::class, [ 
                'class' => Specialites::class,
                'constraints' => new UnAgentAvecLaSpecialiteDeMission(),
            ]) 
            ->add('pays', EntityType::class, [ 
                'class' => Pays::class,
                'constraints' => [new CiblesAgents(),new ContactsPays(),new MissionPlanques()],
            ])
            ->add('planques', EntityType::class, array(
                'class' => Planques::class,
                'allow_extra_fields' => true,
                'label' => 'Planques',
                'expanded' =>true ,
                'multiple'=> true,
            ))
            ->add('contacts', EntityType::class, array(
                'class' => Contacts::class,
                'allow_extra_fields' => true,
                'label' => 'Contacts',
                'expanded' =>true ,
                'multiple'=> true,
            ))
            ->add('agents', EntityType::class, array(
                'class' => Agents::class,
                'allow_extra_fields' => true,
                'label' => 'Agents',
                'expanded' =>true ,
                'multiple'=> true,
            ))
            ->add('Cibles', EntityType::class, array(
                'class' => Cibles::class,
                'allow_extra_fields' => true,
                'label' => 'Cibles',
                'expanded' =>true ,
                'multiple'=> true,
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
