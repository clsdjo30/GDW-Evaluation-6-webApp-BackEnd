<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Entity\Mission;
use App\Entity\Skill;
use App\Entity\Statute;
use App\Entity\User;
use App\Repository\AgentRepository;
use App\Repository\CountryRepository;
use App\Repository\MissionRepository;
use App\Repository\StatuteRepository;
use App\Repository\TargetRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    protected MissionRepository $missionRepository;
    protected StatuteRepository $statusRepository;
    protected CountryRepository $countryRepository;
    protected AgentRepository $agentRepository;
    protected TargetRepository $targetsRepository;
    protected AdminUrlGenerator $adminUrlGenerator;

    public function __construct(
        AdminUrlGenerator $adminUrlGenerator,
        MissionRepository $missionRepository,
        StatuteRepository $statusRepository,
        CountryRepository $countryRepository,
        AgentRepository   $agentRepository,
        TargetRepository  $targetsRepository
    )
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
        $this->missionRepository = $missionRepository;
        $this->statusRepository = $statusRepository;
        $this->countryRepository = $countryRepository;
        $this->agentRepository = $agentRepository;
        $this->targetsRepository = $targetsRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('/admin/admin-dashboard.html.twig');
    }

    #[Route('/consultant', name: 'consultant')]
    public function homeDashboard(): Response
    {
        return $this->render('/admin/admin-dashboard.html.twig', [
            'missionsInPreparation' => $this->missionRepository->countStatusInPreparation(),
            'missionsInProgress' => $this->missionRepository->countStatusInProgress(),
            'missionsFinished' => $this->missionRepository->countStatusFinished(),
            'missionsFailed' => $this->missionRepository->countStatusFailed(),
            'totalMission' => $this->missionRepository->countMission(),
            'missionCountries' => $this->countryRepository->countCountry(),
            'missionsStatus' => $this->missionRepository->findBy([
                'status' => '3'
            ]),
            'missionsAgentActif' => $this->agentRepository->findByMissionFinished(),
            'targetKilled' => $this->targetsRepository->findByTargetKilled()

        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('KGB Consulting')
            ->generateRelativeUrls('./admin.admin-dashboard.html.twig');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Revenir au site', 'fas fa-home', 'app_home');
        // Menu des Consultant
        if ($this->isGranted('ROLE_ADMIN')) {
            yield MenuItem::linkToRoute('Ajouter un Consultant', 'fas fa-plus', 'app_register');
            yield MenuItem::subMenu('Consultant', 'fas fa-user')
                ->setSubItems([
                    MenuItem::linkToCrud('Voir', 'fas fa-eye', User::class)
                        ->setAction(Crud::PAGE_INDEX)
                ]);
        }


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
