<?php

namespace App\Services\Book\Index;


class Request
{
    private $id;
    private $title;
    private $genre;
    private $author;
    private $annotation;

    /**
     * Response constructor.
     * @param $id
     * @param $title
     * @param $genre
     * @param $author
     * @param $annotation
     */
    public function __construct($id, $title, $genre, $author, $annotation)
    {
        $this->id = $id;
        $this->title = $title;
        $this->genre = $genre;
        $this->author = $author;
        $this->annotation = $annotation;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

}