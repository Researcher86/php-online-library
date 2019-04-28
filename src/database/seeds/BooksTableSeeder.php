<?php

use App\Models\Book\Author;
use App\Models\Book\Book;
use App\Models\Book\Genre;
use App\Models\Book\Image;
use App\Models\Book\Rating;
use App\Models\User;
use App\Services\Book\Index\IndexBookServiceInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class BooksTableSeeder extends Seeder
{
    /**
     * @var IndexBookServiceInterface
     */
    private $indexBookService;

    /**
     * BooksTableSeeder constructor.
     */
    public function __construct()
    {
        $this->indexBookService = App::make(IndexBookServiceInterface::class);
        $this->indexBookService->restore();
    }

    public function run()
    {
        $filesPath = __DIR__ . '/../../storage/app/public/files/';
        if (PHP_OS === 'Windows' && file_exists($filesPath)) {
            exec(sprintf("rd /s /q %s", escapeshellarg($filesPath)));
        } else {
            exec(sprintf("rm -rf %s", escapeshellarg($filesPath)));
        }

        $root = new Printer();
        $root->setNext(new MoveImage($filesPath))
            ->setNext(new BookParser())
            ->setNext(new Indexer($this->indexBookService));

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/books'));
        $results = new RegexIterator($iterator, '/^.+\.json/i', RecursiveRegexIterator::GET_MATCH);

        foreach ($results as $file) {
            $root->handle($file[0]);
        }

    }
}

class Printer extends AbstractHandler
{
    public function handle($request)
    {
        Log::info($request);
        parent::handle($request);
    }
}

class MoveImage extends AbstractHandler
{
    private $destDir;

    /**
     * MoveFile constructor.
     * @param $destDir
     */
    public function __construct($destDir)
    {
        $this->destDir = $destDir;
    }

    public function handle($jsonFile)
    {
        $bookId = microtime();
        $json = json_decode(file_get_contents($jsonFile));
        $imageName = basename($json[0]);

        $sourceDir = dirname($jsonFile) . '/' . $imageName;
        $destDir = $this->destDir . date('Y-m-d') . '/books/' . $bookId;
        if (!file_exists($destDir)) {
            mkdir($destDir, 0777, true);
        }
        try {
            copy($sourceDir, $destDir . '/' . $imageName);

            parent::handle(['json_file' => $jsonFile, 'image' => '/files/' . str_replace($this->destDir, '', $destDir) . '/' . $imageName]);
        } catch (\Exception $e) {
            Log::warning($this->destDir);
            Log::warning($destDir);
            Log::error($e->getMessage());
        }
    }

}

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

class Indexer extends AbstractHandler
{
    /**
     * @var IndexBookServiceInterface
     */
    private $indexBookService;

    /**
     * Indexer constructor.
     * @param IndexBookServiceInterface $indexBookService
     */
    public function __construct(IndexBookServiceInterface $indexBookService)
    {
        $this->indexBookService = $indexBookService;
    }

    public function handle($request)
    {
        $this->indexBookService->add($request);
        parent::handle($request);
    }

}


abstract class AbstractHandler
{
    /**
     * @var AbstractHandler
     */
    private $nextHandler;

    public function setNext(AbstractHandler $handler): AbstractHandler
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle($request)
    {
        if ($this->nextHandler) {
            $this->nextHandler->handle($request);
        }
    }
}