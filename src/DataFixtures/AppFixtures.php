<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Kind;
use App\Entity\Borrower;
use App\Entity\Borrowing;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory as FakerFactory;
use Doctrine\Persistence\ObjectManager;
use Easybook\Slugger;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        $countBook = 1000;
        $countBookPerAuthor = 2;

        $this->loadAdmins($manager);
        $kinds = $this->loadKinds($manager);
        $authors = $this->loadAuthors($manager);
        $borrowers = $this->loadBorrowers($manager);
        $books = $this->loadBooks($manager, $countBook, $authors,$countBookPerAuthor,$kinds);
        $this->loadBorrowings($manager, $books, $borrowers);

        $manager->flush();
    }

    public function loadAdmins(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@example.com');
        $user->setPassword('123');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
    }

    public function loadKinds(ObjectManager $manager)
    {

        $kinds = [];

        $kind = new Kind();
        $kind->setName('poésie');
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName('nouvelle');
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName('roman historique');
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("roman d'amour");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("roman d'aventure");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("science-fiction");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("fantasy");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("biographie");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("conte");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("témoignage");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("théâtre");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("essai");
        $manager->persist($kind);
        $kinds[] = $kind;

        $kind = new Kind();
        $kind->setName("journal intime");
        $manager->persist($kind);
        $kinds[] = $kind;

        return $kinds;
    }

    public function loadAuthors(ObjectManager $manager)
    {

        $authors = [];

        $author = new Author();
        $author->setLastname('auteur inconnu');
        $author->setFirstname('');
        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Cartier');
        $author->setFirstname('Hugues');
        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Lambert');
        $author->setFirstname('Armand');
        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Moitessier');
        $author->setFirstname('Thomas');
        $manager->persist($author);
        $authors[] = $author;

        for ($i = 4; $i < 500; $i++) {

            $author = new Author();
            $author->setLastname($this->faker->lastname());
            $author->setFirstname($this->faker->firstname());
            $manager->persist($author);
            $authors[] = $author;

        }
        return $authors;
    }

    public function loadBooks(ObjectManager $manager,int $count,array $authors,int $countBookPerAuthor,array $kinds)
    {

        $authorIndex = 0;
        $author = $authors[$authorIndex];

        $books = [];

        $book = new Book();
        $book->setTitle('');
        $book->setEditing(2010);
        $book->setPages(100);
        $book->setCodeIsbn('9785786930024');
        $book->setAuthor($author);
        $book->addKind($kinds[0]);
        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Lorem ipsum dolor sit amet');
        $book->setEditing(2011);
        $book->setPages(150);
        $book->setCodeIsbn('9783817260935');
        $book->setAuthor($author);
        $book->addKind($kinds[1]);
        $manager->persist($book);
        $books[] = $book;

        $authorIndex = 1;
        $author = $authors[$authorIndex];

        $book = new Book();
        $book->setTitle('Mihi quidem Antiochum');
        $book->setEditing(2012);
        $book->setPages(200);
        $book->setCodeIsbn('9782020493727');
        $book->setAuthor($author);
        $book->addKind($kinds[2]);
        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Quem audis satis belle');
        $book->setEditing(2013);
        $book->setPages(250);
        $book->setCodeIsbn('9794059561353');
        $book->setAuthor($author);
        $book->addKind($kinds[3]);
        $manager->persist($book);
        $books[] = $book;

        for ($i = 4; $i < $count; $i++) {

            if ($i % $countBookPerAuthor == 0) {
                $authorIndex++;
            }
            $author = $authors[$authorIndex];

            $book = new Book();
            $book->setTitle($this->faker->sentence(1));
            $book->setEditing($this->faker->numberBetween(1800, 2021));
            $book->setPages($this->faker->numberBetween(50, 1000));
            $book->setCodeIsbn($this->faker->ean13());
            $book->setAuthor($author);
            $book->addKind($kinds[random_int(0,12)]);
            $manager->persist($book);
            $books[] = $book;
        }
        return $books;
    }

    public function loadBorrowers(ObjectManager $manager)
    {
        $borrowers = [];

        $date_format = 'Y-m-d H:i:s';
        $fake_phonenumber = '123456789';

        //! 1st
        $user = new User();
        $user->setEmail('foo.foo@example.com');
        $user->setPassword('123');
        $user->setRoles(['ROLE_EMPRUNTEUR']);
        $manager->persist($user);

        $borrower = new Borrower();
        $borrower->setLastname('foo');
        $borrower->setFirstname('foo');
        $borrower->setPhone($fake_phonenumber);
        $borrower->setActive(true);
        $borrower->setDateCreation(\DateTime::createFromFormat($date_format, '2020-01-01 10:00:00'));
        $borrower->setUser($user);

        $manager->persist($borrower);

        $borrowers[] = $borrower;

        //! 2nd
        $user = new User();
        $user->setEmail('bar.bar@example.com');
        $user->setPassword('123');
        $user->setRoles(['ROLE_EMPRUNTEUR']);
        $manager->persist($user);

        $borrower = new Borrower();
        $borrower->setLastname('bar');
        $borrower->setFirstname('bar');
        $borrower->setPhone($fake_phonenumber);
        $borrower->setActive(false);
        $borrower->setDateCreation(\DateTime::createFromFormat($date_format, '2020-02-01 11:00:00'));
        $borrower->setDateModification(\DateTime::createFromFormat($date_format, '2020-05-01 12:00:00'));
        $borrower->setUser($user);
        $manager->persist($borrower);

        $borrowers[] = $borrower;

        //! 3rd
        $user = new User();
        $user->setEmail('baz.baz@example.com');
        $user->setPassword('123');
        $user->setRoles(['ROLE_EMPRUNTEUR']);
        $manager->persist($user);

        $borrower = new Borrower();
        $borrower->setLastname('baz');
        $borrower->setFirstname('baz');
        $borrower->setPhone($fake_phonenumber);
        $borrower->setActive(true);
        $borrower->setDateCreation(\DateTime::createFromFormat($date_format, '2020-03-01 12:00:00'));
        $borrower->setUser($user);
        $manager->persist($borrower);

        $borrowers[] = $borrower;

        for ($i = 3; $i < 100; $i++) {
            // Utilisation de variables intermédiaire pour que le nom/prénom des Users(mail)
            // correspondent aux Borrowers(lastname/firstname)
            $lastname = $this->faker->lastname();
            $firstname = $this->faker->firstname();

            $slugger = new Slugger();
            $slugLastname = $slugger->slugify($lastname);
            $slugFirstname = $slugger->slugify($firstname);

            $user = new User();
            $user->setEmail($slugLastname.'.'.$slugFirstname.'@'.$this->faker->freeEmailDomain());
            $user->setPassword('123');
            $user->setRoles(['ROLE_EMPRUNTEUR']);
            $manager->persist($user);

            $borrower = new Borrower();
            $borrower->setLastname($lastname);
            $borrower->setFirstname($firstname);
            $borrower->setPhone($this->faker->phoneNumber());
            $borrower->setActive($this->faker->boolean());
            $borrower->setDateCreation(\DateTime::createFromFormat($date_format, '2020-03-01 12:00:00'));
            $borrower->setUser($user);
            $manager->persist($borrower);

            $borrowers[] = $borrower;
        }
        return $borrowers;
    }

    public function loadBorrowings(ObjectManager $manager,array $books,array $borrowers)
    {
        $borrowings = [];

        $date_format = 'Y-m-d H:i:s';

        $borrowing = new Borrowing();
        $borrowing->setDateBorrowing(\DateTime::createFromFormat($date_format, '2020-02-01 10:00:00'));
        $borrowing->setDateReturn(\DateTime::createFromFormat($date_format, '2020-03-01 10:00:00'));
        $borrowing->setBorrower($borrowers[random_int(0,99)]);
        $borrowing->setBook($books[random_int(0,499)]);
        $manager->persist($borrowing);

        $borrowings[] = $borrowing;

        $borrowing = new Borrowing();
        $borrowing->setDateBorrowing(\DateTime::createFromFormat($date_format, '2020-03-01 10:00:00'));
        $borrowing->setDateReturn(\DateTime::createFromFormat($date_format, '2020-04-01 10:00:00'));
        $borrowing->setBorrower($borrowers[1]);
        $borrowing->setBook($books[1]);
        $manager->persist($borrowing);

        $borrowings[] = $borrowing;

        $borrowing = new Borrowing();
        $borrowing->setDateBorrowing(\DateTime::createFromFormat($date_format, '2020-04-01 10:00:00'));
        $borrowing->setDateReturn(NULL);
        $borrowing->setBorrower($borrowers[2]);
        $borrowing->setBook($books[2]);
        $manager->persist($borrowing);

        $borrowings[] = $borrowing;

        for ($i = 3; $i < 200; $i++) {

            $borrowing = new Borrowing();
            $borrowing->setDateBorrowing($this->faker->dateTimeThisDecade());
            $startDate = $borrowing->getDateBorrowing();
            $endDate = \DateTime::createFromFormat($date_format, $startDate->format($date_format));
            $endDate->add(new \DateInterval('P1M'));
            $borrowing->setDateReturn($endDate);
            $borrowing->setBorrower($borrowers[random_int(0,99)]);
            $borrowing->setBook($books[random_int(0,499)]);
            $manager->persist($borrowing);

            $borrowings[] = $borrowing;
        }
        return $borrowings;
    }
}
?>