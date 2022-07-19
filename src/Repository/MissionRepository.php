<?php

namespace App\Repository;

use App\Entity\Mission;
use App\Entity\Target;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mission>
 *
 * @method Mission|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mission|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mission[]    findAll()
 * @method Mission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mission::class);
    }

    public function add(Mission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Mission $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Target $targets
     * @return array
     */
    public function findTargetFromMission(Target $targets): array
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->join('m.target', 'u')
            ->where('u.firstname = :firstname')
            ->setParameter('firstname', $targets->getFirstname());
        return $queryBuilder->getQuery()->getResult();

    }

    /**
     * @return float|int|mixed|string
     */
    public function countStatusInPreparation(): mixed
    {
        $totalInPreparation = $this->createQueryBuilder('m')
            ->join('m.status', 's')
            ->where('s.id = 1')
            ->select('COUNT(s.id) as value');
        return $totalInPreparation->getQuery()->getResult();

    }

    /**
     * @return float|int|mixed|string
     */
    public function countStatusInProgress(): mixed
    {
        $totalInProgress = $this->createQueryBuilder('m')
            ->join('m.status', 's')
            ->where('s.id = 2')
            ->select('COUNT(s.id) as value');
        return $totalInProgress->getQuery()->getResult();

    }

    /**
     * @return float|int|mixed|string
     */
    public function countStatusFinished(): mixed
    {
        $totalFinished = $this->createQueryBuilder('m')
            ->join('m.status', 's')
            ->where('s.id = 3')
            ->select('COUNT(s.id) as value');
        return $totalFinished->getQuery()->getResult();

    }

    /**
     * @return float|int|mixed|string
     */
    public function countStatusFailed(): mixed
    {
        $totalFailed = $this->createQueryBuilder('m')
            ->join('m.status', 's')
            ->where('s.id = 4')
            ->select('COUNT(s.id) as value');
        return $totalFailed->getQuery()->getResult();

    }

    /**
     * @return float|int|mixed|string
     */
    public function countMission(): mixed
    {
        $totalMission = $this->createQueryBuilder('m')
            ->select('COUNT(m.id) as value');
        return $totalMission->getQuery()->getResult();

    }
}
