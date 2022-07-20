<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Form\AgentType;
use App\Form\ContactType;
use App\Form\HideoutType;
use App\Form\TargetType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
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

    public function configureActions(Actions $actions): Actions
    {


        $missionDetails = Action::new('missionDetail', 'Détails')
            ->linkToCrudAction(Crud::PAGE_DETAIL);


        return $actions
            ->add(Crud::PAGE_INDEX, $missionDetails);
    }


    public function configureFields(string $pageName): iterable
    {

        yield FormField::addTab("Informations de Mission");
        yield AssociationField::new('user', 'Consultant');
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
        yield FormField::addPanel('Les Cibles et les Agents');
        yield CollectionField::new('targets', 'Cible')
            ->setColumns(6)
            ->setEntryType(TargetType::class)
            ->setEntryIsComplex()
            ->setRequired(true);

        yield CollectionField::new('agents', 'Agents')
            ->setColumns(6)
            ->setEntryType(AgentType::class)
            ->setRequired(true);

        // Affichage du contact
        yield FormField::addPanel('Les Contacts');
        yield CollectionField::new('contacts', 'Contact')
            ->setEntryType(ContactType::class)
            ->setRequired(true);


        // Affichage des Planques
        yield FormField::addPanel('Les Planques');
        yield CollectionField::new('hideout', 'Planques')
            ->setEntryType(HideoutType::class)
            ->setRequired(false);


    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {


        if (!$entityInstance instanceof Mission) {
            return;
        }


        if (!$entityInstance->missionIsValid()) {

            $this->addFlash('error', 'Votre formulaire contient des erreurs');

        }

        $entityInstance->setStartAt(new DateTime());
        $entityInstance->setEndAt(new DateTime());

        $this->addFlash('success', 'Votre Mission a bien été ajouter à votre liste de mission');

        parent::persistEntity($em, $entityInstance);
    }

}
