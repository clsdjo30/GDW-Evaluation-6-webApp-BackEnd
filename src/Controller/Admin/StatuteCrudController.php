<?php

namespace App\Controller\Admin;

use App\Entity\Statute;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class StatuteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Statute::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
