<?php

namespace App\Modules\Movie\Models;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    protected $fillable = ["movie_id", "room_name", "start_time", "end_time", "price"];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
