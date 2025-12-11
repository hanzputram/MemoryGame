<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class GameScore extends Model
{
    protected $fillable = [
        'user_id',
        'level',
        'time_seconds',
        'points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
