<?php

namespace App\Controller\Admin;

use App\Entity\Agents;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class AgentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agents::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('nom'),
            Field::new('prenom'),
            DateField::new('date_de_naissance'),
            AssociationField::new('specialites'),
            AssociationField::new('nom_de_code'),
            AssociationField::new('nationalite'),
            AssociationField::new('missions'),
        ];
    }
}
