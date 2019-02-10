<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail(int $int)
 * @method static firstOrCreate(array $array)
 */
class Genre extends Model
{
    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_genres', 'genre_id', 'book_id');
    }
}
