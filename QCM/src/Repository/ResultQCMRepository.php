<?php

namespace App\Repository;

use App\Entity\ResultQCM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResultQCM|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultQCM|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultQCM[]    findAll()
 * @method ResultQCM[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultQCMRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResultQCM::class);
    }

//    /**
//     * @return ResultQCM[] Returns an array of ResultQCM objects
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
    public function findOneBySomeField($value): ?ResultQCM
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
