<?php

namespace App\Handler\Book;


class ClearDir extends AbstractHandler
{
    private $path;


    /**
     * ClearDir constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle($request)
    {
        if (PHP_OS === 'Windows' && file_exists($this->path)) {
            exec(sprintf("rd /s /q %s", escapeshellarg($this->path)));
        } else {
            exec(sprintf("rm -rf %s", escapeshellarg($this->path)));
        }

        parent::handle($request);
    }
}