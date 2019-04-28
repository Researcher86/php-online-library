<?php

namespace App\Services\Book;


use App\Events\BookUploadEvent;
use App\Events\SendEmailEvent;
use App\Events\SendSmsEvent;
use App\Models\Book\Book;
use App\Models\Book\Genre;
use App\Models\Book\Rating;
use Illuminate\Support\Facades\Log;

class BookService implements BookServiceInterface
{

    public function getAll(int $size = 8)
    {
        event(new BookUploadEvent(Book::findOrFail(1)));
        event(new SendEmailEvent("Test@test.com", "Email"));
        event(new SendSmsEvent("87011010101", "SMS"));

        return Book::orderBy('created_at', 'asc')->paginate($size);
    }

    public function getById(int $id): Book
    {
        return Book::findOrFail($id);
    }

    public function getBooksByGenre(int $genreId, int $size = 8)
    {
        return Genre::findOrFail($genreId)->books()->paginate($size);
    }

    public function addRating(int $userId, int $bookId, int $rating): float
    {
        /** @var Book $book */
        $book = Book::findOrFail($bookId);
        $book->addRating(Rating::create($rating, $userId));

        return $book->calculateRatingAverage();
    }

    public function getTop(int $limit = 5)
    {
        return Book::top($limit);
    }
}