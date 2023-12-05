<?php

namespace App\Repository;

use App\Entity\Offres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offres>
 *
 * @method Offres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offres[]    findAll()
 * @method Offres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offres::class);
    }
    public function countByDestination(): array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o.destination, COUNT(o) as quantity')
            ->groupBy('o.destination');
    
        $results = $queryBuilder->getQuery()->getResult();
    
        $stats = [];
        foreach ($results as $result) {
            $destination = $result['destination'];
            $quantity = $result['quantity'];
            $stats[$destination] = $quantity;
        }
    
        return $stats;
    }
    public function findByDestination($destination)
    {
        $qb = $this->createQueryBuilder('o');
    
        if ($destination) {
            $qb->andWhere('o.destination = :destination')
                ->setParameter('destination', $destination);
        }
    
        return $qb->getQuery()->getResult(); // Retourne les résultats de la requête
    }
    public function findAllSortedByDate($sort = 'asc')
{
    $qb = $this->createQueryBuilder('r');

    $order = ($sort === 'asc') ? 'ASC' : 'DESC';
    
    $qb->addOrderBy('r.debut', $order);

    return $qb->getQuery()->getResult();
}
}    

//    /**
//     * @return Offres[] Returns an array of Offres objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Offres
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

