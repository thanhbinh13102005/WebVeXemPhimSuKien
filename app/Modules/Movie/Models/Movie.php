<?php

namespace App\Modules\Movie\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        "title", "description", "duration_minutes", "director",
        "actors", "genre", "age_rating", "poster", "trailer_url", "status",
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
