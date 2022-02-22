<?php

namespace App\Controller\Admin;

use App\Entity\Specialites;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class SpecialitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Specialites::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('nom'),
            AssociationField::new('agents'),
            AssociationField::new('missions'),
        ];
    }
    
}
