<?php

namespace App\Models;

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
