<?php

namespace App\Repository;

use App\Entity\Bonplan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bonplan>
 *
 * @method Bonplan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bonplan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bonplan[]    findAll()
 * @method Bonplan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BonplanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bonplan::class);
    }

//    /**
//     * @return Bonplan[] Returns an array of Bonplan objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bonplan
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
