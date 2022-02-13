<?php

namespace App\Form;

use App\Entity\Missions;
use App\Entity\Planques;
use App\Entity\Pays;
use App\Repository\PlanquesRepository;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysEtPlanquesPourMissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pays'
        #,CollectionType::class,[
            #'class' => PaysType::class,
            #'placeholder' => 'choisir',
            #'choice_label' => 'nom',
            #'mapped' => true,
            #'choice_value' => 'id'
        #]
    );
        $builder
        ->get('pays')->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
            $form = $event->getForm()->getParent();
            $data=  $form->getData();
            $this->getPlanqueFromPays($form,$data);
            
             dump($data);
            if($data){
                #$pl = $data-> getCode();
                #$mission->setPays($data); 
                #$form->get('pays')->setData($data);
            }
            }
        );
       

       
    }


    /**
     * Rajoute le champs planque au formulaire
     * @param FormInterface $form
     * @param int $pays
     */
    private function getPlanqueFromPays(FormInterface $form, ?int $pays){
        $pays = $pays ? $pays : 75;
        $form->getParent()->add('planques',EntityType::class, array(
            'class' => Planques::class,
            'multiple' => true,
            'query_builder' => function(PlanquesRepository $er ) use ($pays)  {
                return $er->createQueryBuilder('u')
                                ->where('u.pays = :data')
                                ->setParameter('data', $pays)
                                ;
                },
            'required' => true,
            'choice_label' => 'code',
            'choice_value' => 'id',
           ));
           
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
