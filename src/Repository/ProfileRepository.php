<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Profile::class);
    }

    // /**
    //  * @return Profile[] Returns an array of Profile objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Profile
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function search($input) {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM profile WHERE nom LIKE :nom or prenom LIKE :prenom or mobile LIKE :mobile or age LIKE :age or ville LIKE :ville";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('nom', "%".$input."%");
        $stmt->bindValue('prenom', "%".$input."%");
        $stmt->bindValue('mobile', "%".$input."%");
        $stmt->bindValue('age', "%".$input."%");
        $stmt->bindValue('ville', "%".$input."%");
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
