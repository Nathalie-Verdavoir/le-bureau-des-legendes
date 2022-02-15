<?php

namespace App\Form;

use App\Entity\Missions;
use App\Entity\Pays;
use App\Entity\Planques;
use App\Repository\PlanquesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

class MissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         $optionsData= $options['data'];
         
        
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
            ->add('specialite') 
           ->add('pays', EntityType::class, [ 
            'class'    => Pays::class,
           ])
           
        ;
        dump($options['data']->getPlanques()[0]);
        if($options['data']->getPlanques()[0]) {
            $builder->add('planques', EntityType::class, [ 
                'class'    => Planques::class,
                'query_builder' =>  $this->getPlanquesParPays($options['data']->getPays()->getid()),
                'multiple' => true,
                'choice_label' => 'code',
               ]);
               $builder
        ->get('pays')->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
            $form = $event->getForm()->getParent();
            $data=  $form->getData();
            $form->add('planques', EntityType::class, [ 
                'class'    => Planques::class,
                'query_builder' =>  $this->getPlanquesParPays( $data->getPays()->getid()),
                'multiple' => true,
                'choice_label' => 'code',
            ])->add('agents')
            ->add('contacts')
            ->add('Cibles');
            }
        );
        }
/*
        $builder
        ->get('pays')->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
            $form = $event->getForm()->getParent();
            $data=  $form->getData();
            $this->getPlanqueFromPays($form,$this->$optionsData->getPays()->getid());
            }
        );*/
    }
    public $originalPays;
    /**
     * Filtre les planques par pays
     * @param int $pays
     */
    public function getPlanquesParPays( int $pays){
       $er=$this->planquesRepository;
            return $er->createQueryBuilder('u')
                            ->where('u.pays = :data')
                            ->setParameter('data', $pays)
                            ;
    }
    public $planquesRepository;
    public function __construct(PlanquesRepository $planquesRepository)
    {
        $this->planquesRepository = $planquesRepository;
    }

    /**
     * Rajoute le champs planque au formulaire
     * @param FormInterface $form
     * @param int $pays
     */
    private function getPlanqueFromPays(FormInterface $form, ?int $pays){
        dump('form' ,$form);
        $form->remove('planques')->add('planques', EntityType::class, [ 
            'class'    => Planques::class,
            'query_builder' =>  $this->getPlanquesParPays($pays),
            'multiple' => true,
            'choice_label' => 'code',
           ])
        ->add('agents')
        ->add('contacts')
        ->add('Cibles');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
