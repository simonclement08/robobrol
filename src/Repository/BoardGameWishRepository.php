<?php

namespace App\Repository;

use App\Entity\BoardGameWish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BoardGameWish>
 *
 * @method BoardGameWish|null find($id, $lockMode = null, $lockVersion = null)
 * @method BoardGameWish|null findOneBy(array $criteria, array $orderBy = null)
 * @method BoardGameWish[]    findAll()
 * @method BoardGameWish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoardGameWishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardGameWish::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BoardGameWish $entity, bool $flush = true): void
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
    public function remove(BoardGameWish $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BoardGameWish[] Returns an array of BoardGameWish objects
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
    public function findOneBySomeField($value): ?BoardGameWish
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
