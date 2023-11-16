<?php

namespace App\Repository;

use App\Entity\LocationVehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LocationVehicule>
 *
 * @method LocationVehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocationVehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocationVehicule[]    findAll()
 * @method LocationVehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationVehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocationVehicule::class);
    }

//    /**
//     * @return LocationVehicule[] Returns an array of LocationVehicule objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LocationVehicule
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
