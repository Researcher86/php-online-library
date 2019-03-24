<?php

namespace App\Handler\Book;


use App\Models\Book\Author;
use App\Models\Book\Book;
use App\Models\Book\Genre;
use App\Models\Book\Image;
use App\Models\Book\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class BookParser extends AbstractHandler
{
    private $user;

    /**
     * BookParser constructor.
     */
    public function __construct()
    {
        $this->user = User::take(1)->first();
    }

    public function handle($request)
    {
        Log::info('Parsing: ' . $request['json_file'] . '...');
        $json = json_decode(file_get_contents($request['json_file']));

        $jsonFile = preg_replace('/.*\/books\//', '', $request['json_file']);

        preg_match('/(.*?)\/(.*?)\//', $jsonFile, $matches);
        $genreName = $this->replaceSymbols($matches[1]);
        $bookName = $this->replaceSymbols($matches[2]);
        $authorName = $this->replaceSymbols($json[2]);
        $annotation = $this->replaceSymbols($json[3]);

        if (!Book::where('title', '=', $bookName)->first()) {
            $genre = Genre::firstOrCreate(['name' => $genreName]);
            $author = Author::firstOrCreate(['name' => $authorName]);
            $image = Image::firstOrCreate(['file' => $request['image']]);

            /** @var Book $book */
            $book = Book::create(['title' => $bookName, 'annotation' => $annotation]);
            $book->addGenre($genre);
            $book->addAuthor($author);
            $book->addImage($image);
            $book->addRating(Rating::create(random_int(1, 5), $this->user->id));

            parent::handle($book);
        }
    }

    private function replaceSymbols(string $string)
    {
        return preg_replace('/«|»/s', '"', $string);
    }
}