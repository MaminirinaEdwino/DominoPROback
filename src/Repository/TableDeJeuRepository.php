<?php

namespace App\Repository;

use App\Entity\TableDeJeu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TableDeJeu>
 *
 * @method TableDeJeu|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableDeJeu|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableDeJeu[]    findAll()
 * @method TableDeJeu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableDeJeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TableDeJeu::class);
    }

    //    /**
    //     * @return TableDeJeu[] Returns an array of TableDeJeu objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TableDeJeu
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
