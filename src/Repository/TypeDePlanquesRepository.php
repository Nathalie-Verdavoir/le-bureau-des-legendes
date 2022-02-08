<?php

namespace App\Repository;

use App\Entity\TypeDePlanques;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeDePlanques|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDePlanques|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDePlanques[]    findAll()
 * @method TypeDePlanques[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDePlanquesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDePlanques::class);
    }

    // /**
    //  * @return TypeDePlanques[] Returns an array of TypeDePlanques objects
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
    public function findOneBySomeField($value): ?TypeDePlanques
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
