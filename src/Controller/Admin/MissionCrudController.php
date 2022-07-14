<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class MissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mission::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Missions')
            ->setEntityLabelInSingular('Mission')
            ->setPageTitle('index', 'Toutes les %entity_label_plural%')
            ->setPageTitle('new', 'Ajouter une nouvelle %entity_label_singular%')
            ->setPaginatorPageSize(8)
            ->showEntityActionsInlined()
            ->setDefaultSort(['id' => 'desc']);

    }


    public function configureFields(string $pageName): iterable
    {

        yield FormField::addTab("Informations de Mission");
        yield IdField::new('id')->hideOnIndex()->hideOnForm();
        yield TextField::new('title', 'Titre de mission')->setColumns(6);
        yield TextField::new('code_name', 'Nom de Code')->setColumns(6);

        yield AssociationField::new('type')->setColumns(6);
        yield DateField::new('startAt')->setColumns(3);
        yield DateField::new('endAt')->setColumns(3);

        yield AssociationField::new('country');

        yield TextareaField::new('description')->setColumns(6);


    }


}
