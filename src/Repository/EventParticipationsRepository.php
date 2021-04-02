<?php

namespace App\Repository;

use App\Entity\EventParticipations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventParticipations|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventParticipations|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventParticipations[]    findAll()
 * @method EventParticipations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventParticipationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventParticipations::class);
    }

    // /**
    //  * @return EventParticipations[] Returns an array of EventParticipations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventParticipations
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
