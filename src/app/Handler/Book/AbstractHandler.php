<?php

namespace App\Handler\Book;


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