<?php

namespace App\Controller\Admin;

use App\Entity\Planques;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class PlanquesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Planques::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('code'),
            Field::new('adresse')->addCssClass('-field-map'),
            AssociationField::new('pays'),
            AssociationField::new('type'),
            AssociationField::new('missions'),
        ];
    }
    
}
