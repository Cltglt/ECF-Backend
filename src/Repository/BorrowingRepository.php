<?php

namespace App\Repository;

use App\Entity\Borrowing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Borrowing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borrowing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borrowing[]    findAll()
 * @method Borrowing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrowing::class);
    }

    public function findBorrowingByBorrowerID(int $id)
    {
        return $this->createQueryBuilder('bi')
            ->innerJoin('bi.borrower', 'be')
            ->where('be.id LIKE :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBorrowingByBookID(int $id)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.book', 'bo')
            ->where('bo.id LIKE :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBorrowingByReturnDate(string $date)
    {
        return $this->createQueryBuilder('b')
            ->where('b.date_return < :date_return')
            ->setParameter('date_return', "%{$date}%")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBorrowingByReturnDateNull()
    {
        return $this->createQueryBuilder('b')
            ->where('b.date_return LIKE :date_return')
            ->setParameter('date_return', null)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBorrowingByBookAndReturn(int $id)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.book', 'bo')
            ->where('bo.id LIKE :id')
            ->andWhere('b.date_return LIKE :date_return')
            ->setParameter('id', $id)
            ->setParameter('date_return', null)
            ->getQuery()
            ->getResult()
        ;
    }

    

    // /**
    //  * @return Borrowing[] Returns an array of Borrowing objects
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
    public function findOneBySomeField($value): ?Borrowing
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
