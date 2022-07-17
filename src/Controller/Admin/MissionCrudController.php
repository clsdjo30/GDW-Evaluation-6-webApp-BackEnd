<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Form\AgentType;
use App\Form\ContactType;
use App\Form\HideoutType;
use App\Form\TargetType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
            ->setDateFormat('dd:MM:yyyy')
            ->showEntityActionsInlined()
            ->setDefaultSort(['id' => 'desc']);

    }


    public function configureFields(string $pageName): iterable
    {

        yield FormField::addTab("Informations de Mission");
        yield IdField::new('id')->hideOnIndex()->hideOnForm();
        yield TextField::new('title', 'Titre de mission')->setColumns(6);
        yield TextField::new('code_name', 'Nom de Code')->setColumns(6);
        yield AssociationField::new('type', 'Type de mission')->setColumns(6);
        yield AssociationField::new('country', 'Pays de mission');
        yield DateField::new('startAt', 'Débute le:')
            ->renderAsChoice(false)
            ->setColumns(4);
        yield DateField::new('endAt', 'Termine le:')
            ->renderAsChoice(false)
            ->setColumns(4);
        yield AssociationField::new('status', 'Statut')
            ->setColumns(4);
        yield TextareaField::new('description')->setColumns(6);

        // Affichage de la cible
        yield FormField::addTab('Les Cibles');
        yield CollectionField::new('targets', 'Cible')
            ->setEntryType(TargetType::class);

        // Affichage du contact
        yield FormField::addTab('Les Contacts');
        yield CollectionField::new('contacts', 'Contact')
            ->setEntryType(ContactType::class);

        // Affichage des Agents
        yield FormField::addTab('Les Agents');
        yield CollectionField::new('agents', 'Agents')
            ->setEntryType(AgentType::class);

        // Affichage des Planques
        yield FormField::addTab('Les Planques');
        yield CollectionField::new('hideout', 'Planques')
            ->setEntryType(HideoutType::class);


    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {


        if (!$entityInstance instanceof Mission) {
            return;
        }

        $entityInstance->setStartAt(new DateTime());
        $entityInstance->setEndAt(new DateTime());

        $this->addFlash('success', 'Votre Mission a bien été ajouter à votre liste de mission');

        parent::persistEntity($em, $entityInstance);
    }

}
