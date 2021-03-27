<?php

namespace App\Repository;

use App\Entity\Artiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Artiles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artiles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artiles[]    findAll()
 * @method Artiles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artiles::class);
    }

    /**
     * @return Artiles[] Returns an array of Artiles objects
     */

    public function findArticleBytitle($title)
    {
        return $this->createQueryBuilder('Article')
            ->where('Article.titre LIKE :titre')
            ->setParameter('titre', '%'.$title.'%')
            ->orderBy('Article.publiele', 'DESC')
            ->getQuery()
            ->getResult()->paginate(5);
    }
    /*public function findByExampleField($value)
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
    public function findOneBySomeField($value): ?Artiles
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
