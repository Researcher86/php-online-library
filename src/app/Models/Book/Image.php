<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static firstOrCreate(array $array)
 */
class Image extends Model
{
    protected $fillable = [
        'file',
    ];

    public $timestamps = false;
}
