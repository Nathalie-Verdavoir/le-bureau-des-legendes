<?php

namespace App\Controller\Admin;

use App\Entity\TypeDePlanques;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeDePlanquesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeDePlanques::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            AssociationField::new('planques'),
        ];
    }
}
