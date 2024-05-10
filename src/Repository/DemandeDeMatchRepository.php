<?php

namespace App\Repository;

use App\Entity\DemandeDeMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeDeMatch>
 *
 * @method DemandeDeMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeDeMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeDeMatch[]    findAll()
 * @method DemandeDeMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeDeMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeDeMatch::class);
    }

    //    /**
    //     * @return DemandeDeMatch[] Returns an array of DemandeDeMatch objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DemandeDeMatch
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
