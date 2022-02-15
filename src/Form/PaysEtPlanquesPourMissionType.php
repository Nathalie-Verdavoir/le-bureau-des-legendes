<?php

namespace App\Form;

use App\Entity\Missions;
use App\Entity\Planques;
use App\Entity\Pays;
use App\Repository\PaysRepository;
use App\Repository\PlanquesRepository;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PaysEtPlanquesPourMissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pays'
            ,EntityType::class,[
                'class' => Pays::class,
                #'placeholder' => 'choisir',
                #'choice_label' => 'nom',
                'mapped' => true,
                #'choice_value' => 'id'
            ]
        );

        $builder
        ->get('pays')->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
            $form = $event->getForm()->getParent();
            $data=  $form->getData();
            dump($data);
            $this->getPlanqueFromPays($form,$data);
            
            // dump($data);
            if($data){
                #$pl = $data-> getCode();
                #$mission->setPays($data); 
                #$form->get('pays')->setData($data);
            }
            }
        );

       
        
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm()->getParent();
                $data=  $form->getData();
               dump($form);
                /* @var $planques Planques */
                $planques = $data->getPlanques();
                if(strlen($planques[0])) {

                    $id=$planques[0]->getPays()->getId();
                    $event->getForm()->get('pays')->setData( $this->getNomDuPays($id));
                }
                else if( $data->getPays()){
                   $event->getForm()->get('pays')->setData( $this->getNomDuPays($data->getPays()->getId()));
                   $this->getPlanqueFromPays($event->getForm(),$data->getPays()->getId());
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
        
        $form->getParent()->add('planques',EntityType::class, array(
            'class' => Planques::class,
            'multiple' => true,
            'query_builder' => function(PlanquesRepository $er ) use ($pays)  {
                return $er->createQueryBuilder('u')
                                ->where('u.pays = :data')
                                ->setParameter('data', $pays)
                                ;
                },
            'choice_label' => 'code',
            'choice_value' => 'id',
           ));
           
    }

    public $paysRepository;
    public function __construct(PaysRepository $paysRepository)
    {
        $this->paysRepository = $paysRepository;
    }

    /**
     * Retrouve le nom du pays
     * @param int $id
     */
    public function getNomDuPays( int $id){
        $id = $id ? $id : 75;
        return $VarName =  $this->paysRepository->find($id);
           
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
