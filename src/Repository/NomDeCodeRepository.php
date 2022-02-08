<?php

namespace App\Repository;

use App\Entity\NomDeCode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NomDeCode|null find($id, $lockMode = null, $lockVersion = null)
 * @method NomDeCode|null findOneBy(array $criteria, array $orderBy = null)
 * @method NomDeCode[]    findAll()
 * @method NomDeCode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NomDeCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NomDeCode::class);
    }

    // /**
    //  * @return NomDeCode[] Returns an array of NomDeCode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NomDeCode
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
