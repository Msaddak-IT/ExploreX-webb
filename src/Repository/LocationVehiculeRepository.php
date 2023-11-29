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
public function findAllSortedByPickupDate($sort = 'asc')
{
    $qb = $this->createQueryBuilder('lv');

    if ($sort === 'asc') {
        $qb->orderBy('lv.pickup_vehicule', 'ASC');
    } elseif ($sort === 'desc') {
        $qb->orderBy('lv.pickup_vehicule', 'DESC');
    }

    return $qb->getQuery()->getResult();
}
/**
     * Check if a vehicle is available for the given period.
     *
     * @param int    $matricule   The matricule of the vehicle.
     * @param string $pickupDate  The pickup date.
     * @param string $returnDate  The return date.
     *
     * @return bool True if the vehicle is available, false otherwise.
     */
    public function isVehicleAvailable(int $matricule, \DateTime $pickupDate, \DateTime $returnDate): bool
{
    // Pas besoin de convertir les objets DateTime, car ils sont déjà passés en tant que paramètres

    // Query pour vérifier si le véhicule est disponible pour la période donnée
    $queryBuilder = $this->createQueryBuilder('l')
        ->andWhere('l.vehicules = :matricule')
        ->andWhere('(:pickupDate BETWEEN l.pickup_vehicule AND l.return_vehicule OR :returnDate BETWEEN l.pickup_vehicule AND l.return_vehicule)')
        ->setParameter('matricule', $matricule)
        ->setParameter('pickupDate', $pickupDate->format('Y-m-d'))
        ->setParameter('returnDate', $returnDate->format('Y-m-d'));

    // Exécuter la requête et obtenir le résultat
    $result = $queryBuilder->getQuery()->getResult();

    // S'il y a des résultats, le véhicule n'est pas disponible
    return empty($result);
}






}





