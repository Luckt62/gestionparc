<?php
// src/Repository/VisiteurMedicalRepository.php

namespace App\Repository;

use App\Entity\VisiteurMedical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VisiteurMedicalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisiteurMedical::class);
    }

    public function searchVisiteurs(string $term = ''): array
    {
        $qb = $this->createQueryBuilder('v');

        if (!empty($term)) {
            $qb->andWhere('v.nom LIKE :term OR v.prenom LIKE :term OR v.email LIKE :term')
               ->setParameter('term', '%' . $term . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
