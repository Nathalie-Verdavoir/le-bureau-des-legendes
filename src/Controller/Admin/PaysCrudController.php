<?php

namespace App\Controller\Admin;

use App\Entity\Pays;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class PaysCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pays::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            Field::new('nom'),
            AssociationField::new('agents'),
            AssociationField::new('cibles'),
            AssociationField::new('contacts'),
            AssociationField::new('planques'),
            AssociationField::new('missions'),
        ];
    }
}
