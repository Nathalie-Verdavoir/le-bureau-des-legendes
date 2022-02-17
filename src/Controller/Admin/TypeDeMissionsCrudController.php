<?php

namespace App\Controller\Admin;

use App\Entity\TypeDeMissions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeDeMissionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeDeMissions::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            AssociationField::new('missions'),
        ];
    }
}
