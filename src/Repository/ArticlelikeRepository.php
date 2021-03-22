<?php

namespace App\Repository;

use App\Entity\Articlelike;
use App\Entity\Artiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articlelike|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articlelike|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articlelike[]    findAll()
 * @method Articlelike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlelikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articlelike::class);
    }
    public function getCountForPost(Artiles $post)
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l) AS nombrelike')
            ->andWhere('l.post = :post')
            ->setParameter('post', $post)
            ->getQuery()
            ->getSingleScalarResult();

    }

    // /**
    //  * @return Articlelike[] Returns an array of Articlelike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Articlelike
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
