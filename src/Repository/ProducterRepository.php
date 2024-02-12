<?php

namespace App\Repository;

use App\Entity\Producter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Producter>
 *
 * @method Producter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producter[]    findAll()
 * @method Producter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProducterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producter::class);
    }

//    /**
//     * @return Producter[] Returns an array of Producter objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Producter
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
