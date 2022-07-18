<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Entity\Mission;
use App\Entity\Skill;
use App\Entity\Statute;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
    }

    #[Route('/admin', name: 'admin')]
    #[Route('/consultant', name: 'consultant')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(MissionCrudController::class)->generateUrl();
        return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('KGB Consulting');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Revenir au site', 'fas fa-home', 'app_home');
        yield MenuItem::subMenu('Missions', 'fas fa-envelope-open-text')
            ->setSubItems([
                MenuItem::linkToCrud('Voir', 'fas fa-eye', Mission::class)
                    ->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Mission::class)
                    ->setAction(Crud::PAGE_NEW)
            ]);

        // Menu des Consultant
        yield MenuItem::subMenu('Consultant', 'fas fa-globe')
            ->setSubItems([
                MenuItem::linkToCrud('Voir', 'fas fa-eye', User::class)
                    ->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        // Menu des Pays
        yield MenuItem::subMenu('Pays', 'fas fa-globe')
            ->setSubItems([
                MenuItem::linkToCrud('Voir', 'fas fa-eye', Country::class)
                    ->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Country::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        // Menu des Skill
        yield MenuItem::subMenu('Spécialités', 'fas fa-globe')
            ->setSubItems([
                MenuItem::linkToCrud('Voir', 'fas fa-eye', Skill::class)
                    ->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Skill::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        // Menu des Status
        yield MenuItem::subMenu('Status de mission', 'fas fa-globe')
            ->setSubItems([
                MenuItem::linkToCrud('Voir', 'fas fa-eye', Statute::class)
                    ->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Statute::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);

    }
}
