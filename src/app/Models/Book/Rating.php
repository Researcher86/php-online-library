<?php

namespace App\Models\Book;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    const MIN = 0.50;
    const MAX = 5.00;

    protected $fillable = [
        'rating', 'user_id'
    ];

    public $timestamps = false;
    public $incrementing = false;

    public static function create(float $rating, int $userId)
    {
        if ($rating < self::MIN || $rating > self::MAX) {
            throw new \DomainException(sprintf('Rating %.2f is not included in the range %.2f..%.2f', $rating, self::MIN, self::MAX));
        }

        return new Rating(['rating' => $rating, 'user_id' => $userId]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}