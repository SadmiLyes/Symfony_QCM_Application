<?php

namespace App\Repository;

use App\Entity\ResultQcm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResultQcm|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultQcm|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultQcm[]    findAll()
 * @method ResultQcm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultQcmRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResultQcm::class);
    }

//    /**
//     * @return ResultQcm[] Returns an array of ResultQcm objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResultQcm
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
