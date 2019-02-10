<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @method static findOrFail(int $int)
 * @method static take(int $int)
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'last_name', 'first_name', 'middle_name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
