<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\BookRepository;
use App\Entity\Book;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function index(BookRepository $bookRepository): Response
    {

        return $this->render('app/index.html.twig', [
            'books' => $bookRepository->findAll()
        ]);
    }

    /**
     * @Route("/book/{id}", name="book_show_for_all", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('app/show.html.twig', [
            'book' => $book,
        ]);
    }
}
