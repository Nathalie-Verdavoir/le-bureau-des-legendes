<?php

namespace App\Form;

use App\Entity\Agents;
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
            ->add('contact', PersonType::class, [
                'data_class' => Agents::class,
            ])
            ->add('specialites', EntityType::class, array(
                'class' => Specialites::class,
                'allow_extra_fields' => true,
                'label' => 'Spécialites',
                'expanded' =>true ,
                'multiple'=> true,
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
