<?php

namespace App\Repository;

use App\Entity\Nationalites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Nationalites|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nationalites|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nationalites[]    findAll()
 * @method Nationalites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NationalitesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nationalites::class);
    }

    // /**
    //  * @return Nationalites[] Returns an array of Nationalites objects
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
    public function findOneBySomeField($value): ?Nationalites
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
