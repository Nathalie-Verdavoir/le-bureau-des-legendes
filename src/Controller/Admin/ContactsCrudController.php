<?php

namespace App\Controller\Admin;

use App\Entity\Contacts;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ContactsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contacts::class;
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
