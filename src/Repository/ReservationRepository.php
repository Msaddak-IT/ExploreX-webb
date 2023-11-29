<?php

namespace App\Repository;

use App\Entity\Reservations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use DateTime;
/**
 * @extends ServiceEntityRepository<Reservations>
 *
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

//    /**
//     * @return Reservations[] Returns an array of Reservations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservations
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
// ...
public function findBySearchTerm($searchTerm)
    {
        // Implement your search logic here, for example using the QueryBuilder
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.field1 LIKE :searchTerm OR e.field2 LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery();

        return $qb->getResult();
    }

public function findAllSortedByDate($sort = 'asc')
{
    $qb = $this->createQueryBuilder('r');

    $order = ($sort === 'asc') ? 'ASC' : 'DESC';
    
    $qb->addOrderBy('r.datedebut', $order);

    return $qb->getQuery()->getResult();
}
public function getClientStatistics()
{
    return $this->createQueryBuilder('r')
        ->select('r.cinclient, COUNT(r.idreservation) as reservationCount')
        ->groupBy('r.cinclient')
        ->getQuery()
        ->getArrayResult();
}
public function isTypeActiviteAvailableForCurrentSeason(string $typeActivite): bool
{
    // Récupérez la saison actuelle
    $currentSeason = $this->getCurrentSeason();

    // Liste des activités non disponibles en hiver
    $activitesNonDisponiblesEnHiver = ['Plongée sous-marine', 'Excursion en bateau'];

    // Vérifiez si l'activité spécifiée est dans la liste des activités non disponibles pour la saison actuelle
    if ($currentSeason === 'hiver' && in_array($typeActivite, $activitesNonDisponiblesEnHiver)) {
        return false; // L'activité n'est pas disponible en hiver
    }

    // Par exemple, vérifiez s'il y a des réservations existantes pour ce type d'activité et cette saison
    $existingReservations = $this->createQueryBuilder('r')
        ->andWhere('r.typeactivite = :typeActivite')
        ->andWhere('r.saison = :saison')
        ->setParameter('typeActivite', $typeActivite)
        ->setParameter('saison', $currentSeason)
        ->getQuery()
        ->getResult();

    // Si des réservations existent pour cette saison et ce type d'activité, le type d'activité n'est pas disponible
    return empty($existingReservations);
}
private function getCurrentSeason(): string
    {
        $currentDate = new DateTime('now');
        $currentMonth = (int)$currentDate->format('n');

        // Déterminez la saison en fonction du mois
        if ($currentMonth >= 4 && $currentMonth <= 9) {
            return 'ete';
        } else {
            return 'hiver';
        }
    }

}



