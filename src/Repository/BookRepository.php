<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

            /**
     * @param $role string nom d'un title comme 'lorem', 'ipsum', etc
     * @return Book[] Returns an array of User objects
     */
    public function findByTitle(string $title)
    {
        // Cette requête génère le code DQL suivant :
        // "SELECT u FROM App\Entity\User u WHERE u.roles LIKE :role"
        // 'u' sera l'alias qui permet de désigner un user.
        return $this->createQueryBuilder('b')
            // Ajout d'un filtre qui ne retient que les users
            // qui contiennent (opérateur LIKE) la chaîne de
            // caractères contenue dans la variable :role.
            ->andWhere('b.title LIKE :title')
            // Affactation d'une valeur à la variable :role.
            // Le symbole % est joker qui veut dire
            // « match toutes les chaînes de caractères ».
            ->setParameter('title', "%{$title}%")
            ->getQuery()
            // Exécution de la requête.
            // Récupération d'un tableau de résultat.
            // Ce tableau peut contenir, zéro, un ou plusieurs lignes.
            ->getResult()
        ;
    }

    /**
     * @param $id int - ID de l'auteur
     * @return Book[] Returns an array of User objects
     */
    public function findByAuthorID(int $id)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.author', 'a')
            ->andWhere('a.id LIKE :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param $role string nom d'un genre comme 'roman'
     * @return Book[] Returns an array of User objects
     */
    public function findByKind(string $kind)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.kind', 'k')
            ->andWhere('k.name LIKE :kind')
            ->setParameter('kind', "%{$kind}%")
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Book[] Returns an array of Book objects
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
    public function findOneBySomeField($value): ?Book
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
