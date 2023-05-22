<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'tagline', 'overview', 'release_date'];

    public function moviesLists()
    {
        return $this->belongsToMany(MovieList::class, 'lists_movies', 'movie_id', 'list_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
