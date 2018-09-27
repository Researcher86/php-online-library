<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'last_name', 'first_name', 'middle_name',
    ];

    public $timestamps = false;
}
