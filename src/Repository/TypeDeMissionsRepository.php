<?php

namespace App\Repository;

use App\Entity\TypeDeMissions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeDeMissions|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDeMissions|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDeMissions[]    findAll()
 * @method TypeDeMissions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDeMissionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDeMissions::class);
    }

    // /**
    //  * @return TypeDeMissions[] Returns an array of TypeDeMissions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeDeMissions
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
