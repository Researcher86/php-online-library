<?php

namespace App\Handler\Book;


use App\Services\Book\Index\IndexBookServiceInterface;

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