<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Endroid\QrCode\Builder\BuilderInterface;
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
     * @return Formations[]
     */
    public function findFormationByid($id)
    {
        return $this->createQueryBuilder('f')
        ->andWhere('f.category = :id')
        ->setParameter('id', $id)
        ->select('f.titre as titre')
        ->getQuery()
        ->getResult();
    
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
  
}
