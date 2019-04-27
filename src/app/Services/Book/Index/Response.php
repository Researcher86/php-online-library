<?php


namespace App\Services\Book\Index;


use App\Models\Book\Book;

class Response
{
    /**
     * @var int
     */
    private $total;
    /**
     * @var Book[]
     */
    private $books;

    /**
     * Response constructor.
     * @param int $total
     * @param Book[] $books
     */
    public function __construct(int $total, array $books)
    {
        $this->total = $total;
        $this->books = $books;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return Book[]
     */
    public function getBooks(): array
    {
        return $this->books;
    }

}