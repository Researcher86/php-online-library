<?php

use App\Models\Book;
use App\Models\Genre;
use App\Models\Author;
use \App\Models\Image;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::take(1)->first();
        foreach (glob(__DIR__ . '/books/*/*/*.json') as $jsonFile) {
            $bookId = microtime();
            $json = json_decode(file_get_contents($jsonFile));

            $jsonFile = str_replace(__DIR__ . '/books/', '', $jsonFile);

            preg_match('/(.*?)\/(.*?)\//', $jsonFile, $matches);
            $genreName = $this->replaceSymbols($matches[1]);
            $bookName = $this->replaceSymbols($matches[2]);
            $authorName = $this->replaceSymbols($json[2]);
            $annotation = $this->replaceSymbols($json[3]);
            $imageName = basename($json[0]);

            $sourceDir = __DIR__ . '/books/' . dirname($jsonFile) . '/' . $imageName;
            $destDir = __DIR__ . '/../../storage/app/public/files/' . date('Y-m-d') . '/books/' . $bookId;
            if (!file_exists($destDir)) {
                mkdir($destDir, 0777, true);
            }
            @copy(
                $sourceDir,
                $destDir . '/' . $imageName
            );

            $genre = Genre::firstOrCreate(['name' => $genreName]);
            $author = Author::firstOrCreate(['name' => $authorName]);
            $image = Image::firstOrCreate(['file' => '/files/' . date('Y-m-d') . '/books/' . $bookId . '/' . $imageName]);

            /** @var Book $book */
            $book = Book::create(['title' => $bookName, 'annotation' => $annotation]);
            $book->addGenre($genre);
            $book->addAuthor($author);
            $book->addImage($image);
            $book->addRating(Rating::create(random_int(1, 5), $user->id));
        }
    }

    private function replaceSymbols(string $string)
    {
        return preg_replace('/«|»/s', '"', $string);
    }
}