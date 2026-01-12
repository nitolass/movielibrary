<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'year',
        'description',
        'duration',
        'age_rating',
        'country',
        'poster'
    ];

    // Relación N:M con géneros
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    // Relación N:M con directores
    public function directors()
    {
        return $this->belongsToMany(Director::class);
    }

    // Relación N:M con actores
    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }
}
