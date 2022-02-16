<?php

namespace App\Form;

use App\Entity\Missions;
use App\Entity\Pays;
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
            ->add('planques')
            ->add('agents')
            ->add('contacts')
            ->add('Cibles');
           
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
