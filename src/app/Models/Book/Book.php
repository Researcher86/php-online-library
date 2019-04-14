<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Book
 * @package App\Models
 * @method static findOrFail(int $id)
 * @method static create(array $array)
 */
class Book extends Model
{
    protected $fillable = [
        'title', 'annotation', 'page_count', 'file'
    ];

    public function getAuthorsNames()
    {
        return $this->authors()->get()->implode('name', ', ');
    }

    public function addAuthor(Author $author): void
    {
        $this->authors()->attach($author);
    }

    public function getGenresNames()
    {
        return $this->genres()->get()->implode('name', ', ');
    }

    public function getGenres()
    {
        return $this->genres()->get()->map(function ($genre) {
            return ['id' => $genre->id, 'name' => $genre->name];
        })->all();
    }

    public function getImagesFiles()
    {
        return $this->images()->get()->implode('files', ', ');
    }

    public function addGenre(Genre $genre)
    {
        return $this->genres()->attach($genre);
    }

    public function addImage(Image $image)
    {
        return $this->images()->attach($image);
    }

    public function addRating(Rating $rating)
    {
        if (Rating::checkExists($this->id, $rating->user_id)) {
            throw new \DomainException('You can not put the rating more than once.');
        }

        return $this->ratings()->save($rating);
    }

    public function calculateRatingAverage()
    {
        $average = $this->ratings()->average('rating');
        $mult = pow(10, 2);

        return ceil($average * $mult) / $mult;
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'book_id', 'id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'book_images', 'book_id', 'image_id');
    }

    public function getPrimaryImage()
    {
        return $this->images()->first()->file;
    }
}
