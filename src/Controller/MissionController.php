<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Repository\MissionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionController extends AbstractController
{
    #[Route('/mission', name: 'app_mission')]
    public function index(
        MissionRepository  $missionRepository,
        PaginatorInterface $paginator,
        Request            $request
    ): Response
    {
        $data = $missionRepository->findAll();

        $missions = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            4
        );

        return $this->render('mission/index.html.twig', [
            'missions' => $missions
        ]);
    }

    #[Route('/mission/{id}', methods: ['GET'], name: 'mission_show')]
    public function missionShow(Mission $mission): Response
    {
        // Symfony's 'dump()' function is an improved version of PHP's 'var_dump()' but
        // it's not available in the 'prod' environment to prevent leaking sensitive information.
        // It can be used both in PHP files and Twig templates, but it requires to
        // have enabled the DebugBundle. Uncomment the following line to see it in action:
        //
        // dump($post, $this->getUser(), new \DateTime());
        //
        // The result will be displayed either in the Symfony Profiler or in the stream output.
        // See https://symfony.com/doc/current/profiler.html
        // See https://symfony.com/doc/current/templates.html#the-dump-twig-utilities
        //
        // You can also leverage Symfony's 'dd()' function that dumps and
        // stops the execution

        return $this->render('mission/mission_show.html.twig', ['mission' => $mission]);
    }
}
