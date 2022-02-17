<?php

namespace App\Controller\Admin;

use App\Entity\NomDeCode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class NomDeCodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NomDeCode::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('code'),
            AssociationField::new('agents'),
            AssociationField::new('cibles'),
            AssociationField::new('contacts'),
            AssociationField::new('planques'),
            AssociationField::new('missions'),
        ];
    }
   
}
