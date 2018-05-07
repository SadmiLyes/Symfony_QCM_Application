<?php

namespace App\Repository;

use App\Entity\ResultQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResultQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultQuestion[]    findAll()
 * @method ResultQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultQuestionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResultQuestion::class);
    }

//    /**
//     * @return ResultQuestion[] Returns an array of ResultQuestion objects
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
    public function findOneBySomeField($value): ?ResultQuestion
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
