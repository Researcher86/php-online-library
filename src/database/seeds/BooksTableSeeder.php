<?php

use App\Handler\Book\BookParser;
use App\Handler\Book\ClearDir;
use App\Handler\Book\FindFile;
use App\Handler\Book\Indexer;
use App\Handler\Book\MoveImage;
use App\Handler\Book\Printer;
use App\Services\Index\IndexBookServiceInterface;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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
        $root = new ClearDir(__DIR__ . '/../../storage/app/public/files/');
        $root->setNext(new FindFile(__DIR__ . '/books/*/*/*.json'))
            ->setNext(new MoveImage(__DIR__ . '/../../storage/app/public/files/'))
            ->setNext(new BookParser())
//            ->setNext(new Printer())
            ->setNext(new Indexer($this->indexBookService));

        $root->handle(null);
    }
}