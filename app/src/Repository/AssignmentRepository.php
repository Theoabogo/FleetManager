<?php

namespace App\Repository;

use App\Entity\Assignment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Vehicle;


/**
 * @extends ServiceEntityRepository<Assignment>
 */
class AssignmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assignment::class);
    }

//    /**
//     * @return Assignment[] Returns an array of Assignment objects
//     */
//   public function findActiveByVehicle(Vehicle $vehicle): ?Assignment
 //  {
  //     return $this->createQueryBuilder('a')
  //         ->andWhere('a.vehicle = :vehicle')
   //        ->setParameter('vehicle', $vehicle)
    //     ->orderBy('a.id', 'DESC')
    //    ->setMaxResults(1)
  //       ->getQuery()
   //        ->getOneOrNullResult()
   //   ;
 // }

//    public function findOneBySomeField($value): ?Assignment
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
