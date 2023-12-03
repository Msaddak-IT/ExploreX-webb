<?php

namespace App\Repository;

use App\Entity\CodePromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Types\Types;




/**
 * @extends ServiceEntityRepository<CodePromo>
 *
 * @method CodePromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodePromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodePromo[]    findAll()
 * @method CodePromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodePromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodePromo::class);
    }
    public function searchCodePromos($searchTerm)
    {
        $qb = $this->createQueryBuilder('c');

        if ($searchTerm) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('c.code', ':searchTerm'),
                $qb->expr()->like('c.valeur', ':searchTerm')
            ))
                ->setParameter('searchTerm', '%'.$searchTerm.'%');
        }

        $qb->orderBy('c.id', 'ASC');

        return $qb->getQuery()->getResult();
    }

    public function countExpiredCodePromos(): int
    {
        $qb = $this->createQueryBuilder('c');

        $qb->select('COUNT(c.id)')
            ->where($qb->expr()->andX(
                $qb->expr()->isNotNull('c.datexpiration'),
                $qb->expr()->lte('c.datexpiration', ':currentDate')
            ))
            ->setParameter('currentDate', new \DateTime(), Types::DATETIME_MUTABLE);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    public function countNotExpiredCodePromos(): int
    {
        $qb = $this->createQueryBuilder('c');

        $qb->select('COUNT(c.id)')
            ->where($qb->expr()->orX(
                $qb->expr()->isNull('c.datexpiration'),
                $qb->expr()->gt('c.datexpiration', ':currentDate')
            ))
            ->setParameter('currentDate', new \DateTime(), Types::DATETIME_MUTABLE);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }

//    /**
//     * @return CodePromo[] Returns an array of CodePromo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CodePromo
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
