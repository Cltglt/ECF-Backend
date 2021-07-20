<?php

namespace App\Repository;

use App\Entity\Borrower;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Borrower|null find($id, $lockMode = null, $lockVersion = null)
 * @method Borrower|null findOneBy(array $criteria, array $orderBy = null)
 * @method Borrower[]    findAll()
 * @method Borrower[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BorrowerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Borrower::class);
    }

        /**
     * @param $id int - ID de l'user
     * @return Borrower[] Returns an array of User objects
     */
    public function findBorrowerByUserID(int $id)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.user', 'u')
            ->where('u.id LIKE :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $role string - chaine de caractere présente dans firstname ou lastname
     * @return Borrower[] Returns an array of Borrower objects
     */
    public function findByFirstnameOrLastname(string $name)
    {
        return $this->createQueryBuilder('b')
            ->where('b.firstname LIKE :firstname')
            ->orWhere('b.lastname LIKE :lastname')
            ->setParameter('firstname', "%{$name}%")
            ->setParameter('lastname', "%{$name}%")
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $phone int - suite de chiffre présente dans le numéro de téléphone
     * @return Borrower[] Returns an array of Borrower objects
     */
    public function findByPhone(int $phone)
    {
        return $this->createQueryBuilder('b')
            ->where('b.phone LIKE :phone')
            ->setParameter('phone', $phone)
            ->getQuery()
            ->getResult()
        ;
    }

        /**
     * @param $date string - date de référence
     * @return Borrower[] Returns an array of Borrower objects
     */
    public function findByDate(string $date)
    {
        return $this->createQueryBuilder('b')
            ->where('b.date_creation < :date_creation')
            ->setParameter('date_creation', "%{$date}%")
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $active boolean - 
     * @return Borrower[] Returns an array of Borrower objects
     */
    public function findByActive(bool $active)
    {
        return $this->createQueryBuilder('b')
            ->where('b.active LIKE :active')
            ->setParameter('active', $active)
            ->getQuery()
            ->getResult()
        ;
    }


    // /**
    //  * @return Borrower[] Returns an array of Borrower objects
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
    public function findOneBySomeField($value): ?Borrower
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
