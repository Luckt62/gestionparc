<?php
namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicule>
 */
class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

    /**
     * Récupère tous les véhicules triés par marque
     */
    public function findAllSortedByMarque(): array
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.marque', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Récupère les véhicules dont le statut est "Disponible"
     */
    public function findAvailableVehicules(): array
    {
        return $this->createQueryBuilder('v')
            ->where('v.statut = :statut')
            ->setParameter('statut', 'Disponible')
            ->getQuery()
            ->getResult();
    }
}
