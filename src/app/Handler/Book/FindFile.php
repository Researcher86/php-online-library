<?php

namespace App\Handler\Book;


class FindFile extends AbstractHandler
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * FindFile constructor.
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function handle($request)
    {
        foreach (glob($this->pattern) as $jsonFile) {
            parent::handle($jsonFile);
        }
    }

}