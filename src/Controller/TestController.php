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

use App\Entity\Book;


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
        BorrowerRepository $borrowerRepository): Response
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
        // ERROR
        // Provoque l'erreur suivante : 
        // An exception occurred while executing 
        // 'DELETE FROM book WHERE id = ?' with params [123]:
        // SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or 
        // update a parent row: a foreign key constraint fails 
        // (`ecfdatabase`.`borrowing`, CONSTRAINT `FK_226E589716A2B381` FOREIGN KEY 
        // (`book_id`) REFERENCES `book` (`id`))

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



        exit();


        // return $this->render('test/index.html.twig', [
        //     'controller_name' => 'TestController',
        // ]);
    }
}
