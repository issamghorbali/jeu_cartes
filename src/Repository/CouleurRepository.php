<?php

namespace App\Repository;

use App\Entity\Couleur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Couleur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Couleur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Couleur[]    findAll()
 * @method Couleur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouleurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Couleur::class);
    }

    // /**
    //  * @return Couleur[] Returns an array of Couleur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Couleur
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllRandom(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Couleur c ORDER BY RAND() '
        );
        return $query->getResult();

    }
}
