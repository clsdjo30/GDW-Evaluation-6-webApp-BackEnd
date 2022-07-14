<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Entity\Mission;
use App\Entity\Skill;
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
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(MissionCrudController::class)->generateUrl();
        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('KGB Consulting');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Missions', 'fas fa-envelope-open-text')
            ->setSubItems([
                MenuItem::linkToCrud('Voir', 'fas fa-eye', Mission::class)
                    ->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Mission::class)
                    ->setAction(Crud::PAGE_NEW)
            ]);

        // Menu des Pays
        yield MenuItem::subMenu('Pays', 'fas fa-globe')
            ->setSubItems([
                MenuItem::linkToCrud('Voir', 'fas fa-eye', Country::class)
                    ->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Country::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);

        yield MenuItem::subMenu('Spécialités', 'fas fa-globe')
            ->setSubItems([
                MenuItem::linkToCrud('Voir', 'fas fa-eye', Skill::class)
                    ->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Skill::class)
                    ->setAction(Crud::PAGE_NEW),
            ]);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
