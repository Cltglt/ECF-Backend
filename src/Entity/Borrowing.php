<?php

namespace App\Entity;

use App\Repository\BorrowingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BorrowingRepository::class)
 */
class Borrowing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_borrowing;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_return;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="borrowing")
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity=Borrower::class, inversedBy="borrowings")
     */
    private $borrower;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBorrowing(): ?\DateTimeInterface
    {
        return $this->date_borrowing;
    }

    public function setDateBorrowing(\DateTimeInterface $date_borrowing): self
    {
        $this->date_borrowing = $date_borrowing;

        return $this;
    }

    public function getDateReturn(): ?\DateTimeInterface
    {
        return $this->date_return;
    }

    public function setDateReturn(?\DateTimeInterface $date_return): self
    {
        $this->date_return = $date_return;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getBorrower(): ?Borrower
    {
        return $this->borrower;
    }

    public function setBorrower(?Borrower $borrower): self
    {
        $this->borrower = $borrower;

        return $this;
    }
}
