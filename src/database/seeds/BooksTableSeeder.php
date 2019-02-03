<?php

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use \App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        foreach (glob(__DIR__ . '/books/*/*/*.json') as $jsonFile) {
            $json = json_decode(file_get_contents($jsonFile));

            $jsonFile = str_replace(__DIR__ . '/books/', '', $jsonFile);
            preg_match('/(.*?)\/(.*?)\//', $jsonFile, $matches);
            $genreName = $matches[1];
            $bookName = $matches[2];
            $authorName = $json[2];
            $anotation = $json[3];
            $imageName = basename($json[0]);

            $sourceDir = __DIR__ . '/books/' . dirname($jsonFile) . '/' . $imageName;
            $destDir = __DIR__ . '/../../public/img/books/' . date('Y-m-d');
            if (!file_exists($destDir)) {
                mkdir($destDir);
            }
            @copy(
                __DIR__ . '/books/' . dirname($jsonFile) . '/' . $imageName,
                $destDir . '/' . $imageName
            );

            $genre = Genre::firstOrCreate(['name' => $genreName]);
            $author = Author::firstOrCreate(['name' => $authorName]);
            $image = Image::firstOrCreate(['file' => 'img/books/' . date('Y-m-d') . '/' . $imageName]);

            /** @var Book $book */
            $book = Book::create(['title' => $bookName, 'annotation' => $anotation]);
            $book->addGenre($genre);
            $book->addAuthor($author);
            $book->addImage($image);
        }
    }
}