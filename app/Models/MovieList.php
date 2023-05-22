<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieList extends Model
{
    use HasFactory;

    protected $table = 'lists';

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'lists_movies', 'list_id', 'movie_id');
    }
}
