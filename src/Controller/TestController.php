<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\UserRepository;
use App\Repository\BookRepository;
use App\Repository\KindRepository;
use App\Repository\AuthorRepository;
use App\Repository\BorrowerRepository;
use App\Repository\BorrowingRepository;

use App\Entity\Book;
use App\Entity\Borrowing;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(
        UserRepository $userRepository,
        BookRepository $bookRepository,
        AuthorRepository $authorRepository,
        KindRepository $kindRepository,
        BorrowerRepository $borrowerRepository,
        BorrowingRepository $borrowingRepository): Response
    {
        
        $entityManager = $this->getDoctrine()->getManager();

        // USERS
        // Requêtes de lecture :
        // - la liste complète de tous les utilisateurs (de la table `user`)
        $users = $userRepository->findAll();
        dump($users);

        // - les données de l'utilisateur dont l'id est `1`
        $user = $userRepository->find(1);
        dump($user);

        // - les données de l'utilisateur dont l'email est `foo.foo@example.com`
        $user = $userRepository->findByMail('foo.foo@example.com');
        dump($user);

        // - les données des utilisateurs dont l'attribut `roles` contient le mot clé `ROLE_EMPRUNTEUR`
        $users = $userRepository->findByRole('ROLE_EMPRUNTEUR');
        dump($users);

        // BOOKS
        // Requêtes de lecture :
        // - la liste complète de tous les livres
        $books = $bookRepository->findAll();
        dump($books);

        // - les données du livre dont l'id est `1`
        $book = $bookRepository->find(1);
        dump($book);

        // - la liste des livres dont le titre contient le mot clé `lorem`
        $books = $bookRepository->findByTitle('lorem');
        dump($books);

        // - la liste des livres dont l'id de l'auteur est `2`
        $books = $bookRepository->findByAuthorID(2);
        dump($books);

        // - la liste des livres dont le genre contient le mot clé `roman`
        $books = $bookRepository->findByKind('roman');
        dump($books);

        // Requêtes de création 
        // - ajouter un nouveau livre
        // - titre : Totum autem id externum
        // - année d'édition : 2020
        // - nombre de pages : 300
        // - code ISBN : 9790412882714
        // - auteur : Hugues Cartier (id `2`)
        // - genre : science-fiction (id `6`)
        $book = new Book();
        $book->setTitle('Totum autem id externum');
        $book->setEditing(2020);
        $book->setPages(300);
        $book->setCodeIsbn('9790412882714');
        $book->setAuthor($authorRepository->find(2));
        $book->addKind($kindRepository->find(6));
        $entityManager->persist($book);
        $entityManager->flush();
        dump($book);

        // Requêtes de mise à jour :
        // - modifier le livre dont l'id est `2`
        // - titre : Aperiendum est igitur
        // - genre : roman d'aventure (id `5`)
        $book = $bookRepository->find(2);
        $book->setTitle('Aperiendum est igitur');
        $book->addKind($kindRepository->find(5));
        dump($book);

        // Requêtes de suppression :
        // - supprimer le livre dont l'id est `123`
        //! ERROR
        //! Provoque l'erreur suivante : 
        //! An exception occurred while executing 
        //! 'DELETE FROM book WHERE id = ?' with params [123]:
        //! SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or 
        //! update a parent row: a foreign key constraint fails 
        //! (`ecfdatabase`.`borrowing`, CONSTRAINT `FK_226E589716A2B381` FOREIGN KEY 
        //! (`book_id`) REFERENCES `book` (`id`))
        // $entityManager->remove($bookRepository->find(123));
        // $entityManager->flush();
        // $books = $bookRepository->findAll();
        // dump($books);

        // BORROWER
        // Requêtes de lecture :
        // - la liste complète des emprunteurs
        $borrowers = $borrowerRepository->findAll();
        dump($borrowers);

        // - les données de l'emprunteur dont l'id est `3`
        $borrower = $borrowerRepository->find(3);
        dump($borrower);

        // - les données de l'emprunteur qui est relié au user dont l'id est `3`
        $borrower = $borrowerRepository->findBorrowerByUserID(4);
        dump($borrower);

        // - la liste des emprunteurs dont le nom ou le prénom contient le mot clé `foo`
        $borrowers = $borrowerRepository->findByFirstnameOrLastname('foo');
        dump($borrowers);

        // - la liste des emprunteurs dont le téléphone contient le mot clé `1234`
        $borrowers = $borrowerRepository->findByPhone(1234);
        dump($borrowers);

        // - la liste des emprunteurs dont la date de création est antérieure au 01/03/2021 exclu (c-à-d strictement plus petit)

        // Doute sur le fonction
        $borrowers = $borrowerRepository->findByDate('2020-03-01 00:00:00');
        dump($borrowers);

        // - la liste des emprunteurs inactifs (c-à-d dont l'attribut `actif` est égal à `false`)
        $borrowers = $borrowerRepository->findByActive(false);
        dump($borrowers);

        // BORROWING
        // Requêtes de lecture :
        // - la liste des 10 derniers emprunts au niveau chronologique

        // - la liste des emprunts de l'emprunteur dont l'id est `2`
        $borrowings = $borrowingRepository->findBorrowingByBorrowerID(2);
        dump($borrowings);

        // - la liste des emprunts du livre dont l'id est `3`
        $borrowings = $borrowingRepository->findBorrowingByBookID(3);
        dump($borrowings);

        // - la liste des emprunts qui ont été retournés avant le 01/01/2021
        // Doute sur le résultat
        $borrowings = $borrowingRepository->findBorrowingByReturnDate('2021-01-01 00:00:00');
        dump($borrowings);

        // - la liste des emprunts qui n'ont pas encore été retournés (c-à-d dont la date de retour est nulle)
        $borrowings = $borrowingRepository->findBorrowingByReturnDateNull();
        dump($borrowings);

        // - les données de l'emprunt du livre dont l'id est `3` et qui n'a pas encore été retournés (c-à-d dont la date de retour est nulle)
        $borrowings = $borrowingRepository->findBorrowingByBookAndReturn(3);
        dump($borrowings);
        
        // Requêtes de création :
        // - ajouter un nouvel emprunt
        // - date d'emprunt : 01/12/2020 à 16h00
        // - date de retour : aucune date
        // - emprunteur : foo foo (id `1`)
        // - livre : Lorem ipsum dolor sit amet (id `1`)
        $date_format = 'Y-m-d H:i:s';
        $borrowerFoo = $borrowerRepository->find(1);
        $bookLorem = $bookRepository->find(1);

        $borrowing = new Borrowing();
        $borrowing->setDateBorrowing(\DateTime::createFromFormat($date_format, '2020-12-01 16:00:00'));
        $borrowing->setBorrower($borrowerFoo);
        $borrowing->setBook($bookLorem);
        $entityManager->persist($borrowing);
        $entityManager->flush();
        dump($borrowing);


        // Requêtes de mise à jour :
        // - modifier l'emprunt dont l'id est `3`
        // - date de retour : 01/05/2020 à 10h00
        $borrowing = $borrowingRepository->find(3);
        $borrowing->setDateReturn(\DateTime::createFromFormat($date_format, '2020-05-01 10:00:00'));
        dump($borrowing);

        // Requêtes de suppression :
        // - supprimer l'emprunt dont l'id est `42`
        //! ERROR
        //! Provoque l'erreur suivante : 
        //! EntityManager#remove() expects parameter 1 to be an entity object, NULL given.
        // $entityManager->remove($borrowingRepository->find(42));
        // $entityManager->flush();
        // $borrowings = $borrowingRepository->findAll();
        // dump($borrowings);

        exit();

        // return $this->render('test/index.html.twig', [
        //     'controller_name' => 'TestController',
        // ]);
    }
}
