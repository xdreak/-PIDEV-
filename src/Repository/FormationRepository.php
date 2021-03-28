<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }
  /**
     * @return count
     */
    public function countFormation($id)
    {
        return $this->createQueryBuilder('f')
        ->andWhere('f.category = :id')
        ->setParameter('id', $id)
        ->select('count(f.id) as count')
        ->getQuery()
        ->getSingleScalarResult();
    
    }
    /**
     * @return Formations[] Returns an array of Artiles objects
     */

    public function findFormationBytitle($title)
    {
        return $this->createQueryBuilder('Formation')
            ->where('Formation.Titre LIKE :Titre')
            ->setParameter('Titre', '%'.$title.'%')
            ->orderBy('Formation.Date', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    // public function findEntitiesByString($str){
    //     return $this->getEntityManager()
    //         ->createQuery(
    //             'SELECT p
    //             FROM formation p
    //             WHERE p.titre LIKE :str'
    //         )
    //         ->setParameter('str', '%'.$str.'%')
    //         ->getResult();
    // }
    //  /**
    //  * get all posts
    //  *
    //  * @return array
    //  */
    // public function findAllFormations()
    // {
    //     return $this->getEntityManager()
    //         ->createQuery(
    //             'SELECT a
    //      FROM Formation a
      
    //      ORDER BY a.date DESC'
    //         )
    //         ->getArrayResult();
    // }

    // /**
    //  * get one by id
    //  *
    //  * @param integer $id
    //  *
    //  * @return array
    //  */
    // public function findOneById($id)
    // {
    //     return $this->getEntityManager()
    //         ->createQuery(
    //             "SELECT a, u.username
    //    FROM AppBundle:Annonce
    //    a JOIN a.user u
    //     WHERE a.id = id"
    //         )
    //         ->setParameter('id', $id)
    //         ->getArrayResult();
    // }


    // /**
    //  * get one by id
    //  *
    //  * @param integer $id
    //  *
    //  * @return object or null
    //  */
    // public function findFormationByid($id)
    // {
    //     try {
    //         return $this->getEntityManager()
    //             ->createQuery(
    //                 "SELECT p
    //             FROM Formation
    //             p WHERE p.id =:id"
    //             )
    //             ->setParameter('id', $id)
    //             ->getOneOrNullResult();
    //     } catch (NonUniqueResultException $e) {
    //     }
    // }
    
    // /**
    //  * @return Formation[] Returns an array of Formation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
