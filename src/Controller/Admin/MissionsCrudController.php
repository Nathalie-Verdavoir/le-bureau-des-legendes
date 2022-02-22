<?php

namespace App\Controller\Admin;

use App\Entity\Missions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MissionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Missions::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextField::new('description'),
            AssociationField::new('nom_de_code'),
            AssociationField::new('pays'),
            AssociationField::new('agents'),
            AssociationField::new('contacts'),
            AssociationField::new('Cibles'),
            AssociationField::new('type'),
            AssociationField::new('statut'),
            AssociationField::new('planques'),
            AssociationField::new('specialite'),
            DateField::new('date_debut'),
            DateField::new('date_fin'),

        ];
    }
    
}
