<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Kind;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory as FakerFactory;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    private $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create('fr_FR');
    }

    public function load(ObjectManager $manager)
    {
        // $this->loadBooks($manager);
        // $this->loadAuthors($manager);
        // $this->loadKinds($manager);

        // $manager->flush();
    }

    public function loadBooks(ObjectManager $manager)
    {
        $book = new Book();
        $book->setTitle('');
        $book->setEditing(2010);
        $book->setPages(100);
        $book->setCodeIsbn('9785786930024');
        $manager->persist($book);

        $book = new Book();
        $book->setTitle('Lorem ipsum dolor sit amet');
        $book->setEditing(2011);
        $book->setPages(150);
        $book->setCodeIsbn('9783817260935');
        $manager->persist($book);

        $book = new Book();
        $book->setTitle('Mihi quidem Antiochum');
        $book->setEditing(2012);
        $book->setPages(200);
        $book->setCodeIsbn('9782020493727');
        $manager->persist($book);

        $book = new Book();
        $book->setTitle('Quem audis satis belle');
        $book->setEditing(2013);
        $book->setPages(250);
        $book->setCodeIsbn('9794059561353');
        $manager->persist($book);

        for ($i = 0; $i < 1000; $i++) {
            $book = new Book();
            $book->setTitle($this->faker->sentence(1));
            $book->setEditing($this->faker->numberBetween(1800, 2021));
            $book->setPages($this->faker->numberBetween(50, 1000));
            $book->setCodeIsbn($this->faker->numberBetween(0, 9999999999999));
            $manager->persist($book);
        }
    }

    public function loadAuthors(ObjectManager $manager)
    {
        $author = new Author();
        $author->setLastname('auteur inconnu');
        $author->setFirstname('');
        $manager->persist($author);

        $author = new Author();
        $author->setLastname('Cartier');
        $author->setFirstname('Hugues');
        $manager->persist($author);

        $author = new Author();
        $author->setLastname('Lambert');
        $author->setFirstname('Armand');
        $manager->persist($author);

        $author = new Author();
        $author->setLastname('Moitessier');
        $author->setFirstname('Thomas');
        $manager->persist($author);

        for ($i = 0; $i < 500; $i++) {
            $author = new Author();
            $author->setLastname($this->faker->lastname());
            $author->setFirstname($this->faker->firstname());
            $manager->persist($author);
        }
    }

    public function loadKinds(ObjectManager $manager)
    {
        $kind = new Kind();
        $kind->setName('poésie');
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName('nouvelle');
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName('roman historique');
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("roman d'amour");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("roman d'aventure");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("science-fiction");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("fantasy");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("biographie");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("conte");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("témoignage");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("théâtre");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("essai");
        $kind->setDescription(NULL);
        $manager->persist($kind);

        $kind = new Kind();
        $kind->setName("journal intime");
        $kind->setDescription(NULL);
        $manager->persist($kind);
    }
}

?>