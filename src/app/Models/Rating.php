<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    const MIN = 1;
    const MAX = 5;

    protected $fillable = [
        'rating', 'user_id'
    ];

    public $timestamps = false;
    public $incrementing = false;

    public static function create(int $rating, int $userId)
    {
        if ($rating < self::MIN || $rating > self::MAX) {
            throw new \DomainException(sprintf('Rating is not included in the range %d..%d', self::MIN, self::MAX));
        }

        return new Rating(['rating' => $rating, 'user_id' => $userId]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
