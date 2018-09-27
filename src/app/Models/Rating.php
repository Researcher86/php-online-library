<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'rating', 'user_id'
    ];

    public $timestamps = false;

    public static function new(int $rating, User $user)
    {
        if ($rating < 1 || $rating > 5) {
            throw new \DomainException('Rating is not included in the range 1..5');
        }

        return new Rating(['rating' => $rating, 'user_id' => $user->id]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
