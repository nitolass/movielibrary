<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Actor;
use App\Models\Review;


class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'year',
        'description',
        'duration',
        'poster',
        'director_id',
        'genre_id'
    ];

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'actor_movie')
            ->withPivot('character_name')
            ->withTimestamps();
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
