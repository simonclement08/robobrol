<?php

namespace App\Repository;

use App\Entity\BoardGameTheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoardGameTheme>
 *
 * @method BoardGameTheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardGameTheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardGameTheme[]    findAll()
 * @method BoardGameTheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardGameThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardGameTheme::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BoardGameTheme $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(BoardGameTheme $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BoardGameTheme[] Returns an array of BoardGameTheme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BoardGameTheme
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
