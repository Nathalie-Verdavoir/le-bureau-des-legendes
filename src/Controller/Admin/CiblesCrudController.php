<?php

namespace App\Controller\Admin;

use App\Entity\Cibles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CiblesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cibles::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('nom'),
            Field::new('prenom'),
            DateField::new('date_de_naissance'),
            AssociationField::new('nom_de_code'),
            AssociationField::new('nationalite'),
            AssociationField::new('missions'),
        ];
    }
    
}
