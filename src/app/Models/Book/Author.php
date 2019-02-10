<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array)
 */
class Author extends Model
{
    protected $fillable = [
        'name',
    ];

    public $timestamps = false;
}
