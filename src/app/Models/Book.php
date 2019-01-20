<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Book
 * @package App\Models
 * @method static findOrFail(int $id)
 */
class Book extends Model
{
    protected $fillable = [
        'title', 'description', 'page_count', 'file'
    ];

    public function getAuthors()
    {
        return $this->authors()->get();
    }

    public function addAuthors(Author $author): void
    {
        $this->authors()->attach($author);
    }

    public function getGenres()
    {
        return $this->genres()->get();
    }

    public function addGenres(Genre $genre)
    {
        return $this->genres()->attach($genre);
    }

    public function addRating(Rating $rating)
    {
        return $this->ratings()->save($rating);
    }

    public function totalRating()
    {
        return $this->ratings()->sum('rating');
    }

    private function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }

    private function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

    private function ratings()
    {
        return $this->hasMany(Rating::class, 'book_id', 'id');
    }
}
