<?php

namespace App\Repository;

use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Endroid\QrCode\Builder\BuilderInterface;
/**
 * @method Offre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offre[]    findAll()
 * @method Offre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offre::class);
    }


    public function __constructs(BuilderInterface $customQrCodeBuilder)
    {
        $result = $customQrCodeBuilder
            ->size(400)
            ->margin(20)
            ->build();
    }
    // /**
    //  * @return Offre[] Returns an array of Offre objects
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
    public function findOneBySomeField($value): ?Offre
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findOffreByVille($Ville){
        return $this->createQueryBuilder('Offre')
            ->where('Offre.Ville LIKE :Ville')
            ->setParameter('Ville', '%'.$Ville.'%')
            ->getQuery()
            ->getResult();
    }

    public function findOffreByTitle($Title){
        return $this->createQueryBuilder('Offre')
            ->where('Offre.Title LIKE :Title')
            ->setParameter('Title', '%'.$Title.'%')
            ->getQuery()
            ->getResult();
    }



}
