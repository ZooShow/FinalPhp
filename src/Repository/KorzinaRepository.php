<?php

namespace App\Repository;

use App\Entity\Korzina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Korzina|null find($id, $lockMode = null, $lockVersion = null)
 * @method Korzina|null findOneBy(array $criteria, array $orderBy = null)
 * @method Korzina[]    findAll()
 * @method Korzina[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KorzinaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Korzina::class);
    }

    // /**
    //  * @return Korzina[] Returns an array of Korzina objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Korzina
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
