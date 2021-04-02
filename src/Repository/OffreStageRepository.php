<?php

namespace App\Repository;

use App\Entity\OffreStage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;




/**
 * @method OffreStage|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreStage|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreStage[]    findAll()
 * @method OffreStage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreStageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreStage::class);
    }
    /**
     * @return OffreStage[]
     */
    public function findStageByEntreprise($NomEntreprise){
        return $this->createQueryBuilder('OffreStage')
            ->andWhere('OffreStage.NomEntreprise LIKE :NomEntreprise')
            ->setParameter('NomEntreprise', '%'.$NomEntreprise.'%')
            ->getQuery()
            ->getResult();
    }
    /**
     * @return OffreStage[]
     */
    public function triOffresStagesASC(){
        return $this->createQueryBuilder('t')
            ->orderBy('t.NomEntreprise','ASC')
            ->getQuery()
            ->getResult();
    }
    /**
     * @return OffreStage[]
     */
    public function triOffresStagesDESC(){
        return $this->createQueryBuilder('t')
            ->orderBy('t.NomEntreprise','DESC')
            ->getQuery()
            ->getResult();
    }
   /* public function __constructs(BuilderInterface $customQrCodeBuilder)
    {
        $result = $customQrCodeBuilder
            ->size(400)
            ->margin(20)
            ->build();
        $response = new QrCodeResponse($result);
    }
   */



    // /**
    //  * @return OffreStage[] Returns an array of OffreStage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreStage
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
